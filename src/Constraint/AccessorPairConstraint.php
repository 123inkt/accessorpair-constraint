<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory;
use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Exception;
use LogicException;
use PHPUnit\Framework\Constraint\Constraint;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class AccessorPairConstraint extends Constraint
{
    /** @var AccessorPairProvider */
    protected $accessorPairProvider;

    /** @var ConstructorPairProvider */
    protected $constructorPairProvider;

    /** @var ValueProviderFactory */
    protected $valueProviderFactory;

    /** @var ConstraintConfig */
    protected $config;

    /** @var string */
    protected $additionalFailureDesc = '';

    /** @var Inflector */
    private $inflector;

    public function __construct(ConstraintConfig $config)
    {
        $this->accessorPairProvider    = new AccessorPairProvider($config);
        $this->constructorPairProvider = new ConstructorPairProvider();
        $this->valueProviderFactory    = new ValueProviderFactory();
        $this->config                  = $config;

        $this->inflector = InflectorFactory::create()->build();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function matches($other): bool
    {
        if (is_string($other) === false || class_exists($other) === false) {
            $this->fail($other, "Unable to load class");
        }

        try {
            // Inspect the provided class, and fetch all accessorPairs
            $class         = new ReflectionClass($other);
            $accessorPairs = $this->accessorPairProvider->getAccessorPairs($class);

            // Test the default values of all properties
            if ($this->config->hasPropertyDefaultCheck()) {
                $this->testPropertyDefaults($accessorPairs);
            }

            // Test all accessorPairs
            if ($this->config->hasAccessorPairCheck()) {
                foreach ($accessorPairs as $accessorPair) {
                    $this->testAccessorPair($accessorPair);
                }
            }

            // Test all constructorPairs
            $constructorPairs = $this->constructorPairProvider->getConstructorPairs($class);
            if ($this->config->hasAssertConstructor()) {
                foreach ($constructorPairs as $constructorPair) {
                    $this->testConstructorPair($constructorPair);
                }
            }
        } catch (LogicException $e) {
            $this->fail($other, "Unable to run constraint on class. " . $e->getMessage());
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return 'matches constraint';
    }

    /**
     * @inheritDoc
     */
    public function additionalFailureDescription($other): string
    {
        return $this->additionalFailureDesc;
    }

    /**
     * Assert that all the class properties have the correct default values setup.
     * Calling all getter methods should not throw any TypeErrors for example, without calling a setter first.
     *
     * @param AccessorPair[] $accessorPairs
     *
     * @throws Exception
     */
    protected function testPropertyDefaults(array $accessorPairs): void
    {
        $this->additionalFailureDesc = 'Testing initial state of class.';

        foreach ($accessorPairs as $accessorPair) {
            $instanceArgs = array_values($this->getInstanceArgs($accessorPair->getClass()));
            $instance     = $accessorPair->getClass()->newInstanceArgs($instanceArgs);
            $accessorPair->getGetMethod()->invoke($instance);
        }
    }

    /**
     * Test all accessorPairs, by passing test values to the setter and expect the exact same value back from the getter.
     *
     * @throws Exception
     */
    protected function testAccessorPair(AccessorPair $accessorPair): void
    {
        $this->additionalFailureDesc = 'Testing method ' . $accessorPair->getGetMethod()->getName() .
            ' and ' . $accessorPair->getSetMethod()->getName();

        // If the parameter has a default value:
        // assert that when calling the setter without a value provided, the getter returns the parameter default
        $parameter = $accessorPair->getSetMethod()->getParameters()[0];
        if ($parameter->isDefaultValueAvailable()) {
            $this->testOptionalParameter($accessorPair, $parameter);
        }

        // Test the accessorPair with the setup test values
        $testValues = $this->getTestValues($accessorPair->getSetMethod(), $parameter);
        $this->testParameter($parameter, $accessorPair, $testValues);
    }

    /**
     * The setter's parameter has a default value
     * Call the setter without provider a parameter. Then call the getter and expect the default value return.
     *
     * @throws Exception
     */
    protected function testOptionalParameter(AccessorPair $accessorPair, ReflectionParameter $parameter): void
    {
        $expectedReturn = $parameter->getDefaultValue();

        // For "add" methods, we expect the getter to return an array
        if ($accessorPair->hasMultiGetter()) {
            $expectedReturn = [$expectedReturn];
        }

        // Create new instance, call the setter without providing a parameter. Call the getter, and we expect the default value
        $instanceArgs = array_values($this->getInstanceArgs($accessorPair->getClass()));
        $instance     = $accessorPair->getClass()->newInstanceArgs($instanceArgs);
        $accessorPair->getSetMethod()->invoke($instance);
        $storedValue = $accessorPair->getGetMethod()->invoke($instance);

        if ($storedValue !== $expectedReturn) {
            $this->fail(
                $accessorPair->getClass()->getNamespaceName(),
                "Stored value (" . $this->exporter()->export($storedValue) . ") does not match " .
                "default value (" . $this->exporter()->export($expectedReturn) . ")"
            );
        }
    }

    /**
     * @param mixed[] $testValues
     *
     * @throws Exception
     */
    protected function testParameter(ReflectionParameter $parameter, AccessorPair $accessorPair, array $testValues): void
    {
        $instanceArgs = $this->getInstanceArgs($accessorPair->getClass());
        $instance     = $accessorPair->getClass()->newInstanceArgs(array_values($instanceArgs));

        // Try and match setItems/addItem to a constructor parameter called $items.
        // If the match exists, use the constructor param value as starting set for getItems.
        $setterBaseName = $accessorPair->getSetMethod()->getName();
        $setterBaseName = substr($setterBaseName, 3);
        $addedValues    = $instanceArgs[$this->inflector->pluralize(strtolower($setterBaseName))] ?? [];
        foreach ($testValues as $testValue) {
            // Pass test value to the instance
            $accessorPair->getSetMethod()->invoke($instance, $testValue);
            $addedValues[] = $testValue;

            // Retrieve the stored value, should be exactly the same
            $storedValue = $accessorPair->getGetMethod()->invoke($instance);

            if ($accessorPair->hasMultiGetter()) {
                // If the accessorPair has an "add" method, the getter should return All previously passed values
                $expectedReturn = $addedValues;
            } elseif ($parameter->isVariadic()) {
                // If the setter's parameter is variadic (...$param), the getter should return an array of the passed value(s)
                $expectedReturn = [$testValue];
            } else {
                // Otherwise, simply expect the exact same value back
                $expectedReturn = $testValue;
            }

            if ($storedValue !== $expectedReturn) {
                $this->fail(
                    $accessorPair->getClass()->getNamespaceName(),
                    "Stored value (" . $this->exporter()->export($storedValue) . ") does not match " .
                    "given value (" . $this->exporter()->export($expectedReturn) . ")"
                );
            }
        }
    }

    /**
     * @throws Exception
     */
    protected function testConstructorPair(ConstructorPair $constructorPair): void
    {
        $this->additionalFailureDesc = 'Testing method ' . $constructorPair->getGetMethod()->getName() .
            ' and constructor param ' . $constructorPair->getParameter()->getName();

        $class       = $constructorPair->getClass();
        $constructor = $class->getConstructor();
        if ($constructor === null) {
            return;
        }

        $arguments = array_values($this->getInstanceArgs($class));

        // Get all test values for the constructorPair parameter
        $testValues = $this->getTestValues($constructor, $constructorPair->getParameter());
        foreach ($testValues as $testValue) {
            // Set the testValue for the constructorPair parameter
            $arguments[$constructorPair->getParameter()->getPosition()] = $testValue;

            // Create a new instance, with the created arguments array
            $instance = $class->newInstanceArgs($arguments);

            // Retrieve the stored value, should be exactly the same
            $storedValue = $constructorPair->getGetMethod()->invoke($instance);
            if ($constructorPair->getParameter()->isVariadic()) {
                // If the parameter is variadic (...$param), the getter should return an array of the passed value(s)
                $expectedReturn = [$testValue];
            } else {
                // Otherwise, simply expect the exact same value back
                $expectedReturn = $testValue;
            }

            if ($storedValue !== $expectedReturn) {
                $this->fail(
                    $constructorPair->getClass()->getNamespaceName(),
                    "Stored value (" . $this->exporter()->export($storedValue) . ") does not match " .
                    "given value (" . $this->exporter()->export($expectedReturn) . ")"
                );
            }
        }
    }

    /**
     * @return mixed[]
     * @throws Exception
     */
    protected function getTestValues(ReflectionMethod $method, ReflectionParameter $parameter): array
    {
        $resolver = new TypehintResolver($method);
        $typehint = $resolver->getParamTypehint($parameter);

        return $this->valueProviderFactory->getProvider($typehint)->getValues();
    }

    /**
     * Create arguments array for constructor, with a single test value for all parameters
     *
     * @return mixed[]
     * @throws Exception
     */
    protected function getInstanceArgs(ReflectionClass $class): array
    {
        if ($this->config->getConstructorCallback() !== null) {
            return $this->config->getConstructorCallback()();
        }

        $constructor = $class->getConstructor();
        if ($constructor === null) {
            return [];
        }

        $arguments = [];
        foreach ($constructor->getParameters() as $parameter) {
            $testValues                       = $this->getTestValues($constructor, $parameter);
            $arguments[$parameter->getName()] = $testValues[0];
        }

        return $arguments;
    }
}
