<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory;
use Exception;
use LogicException;
use PHPUnit\Framework\Constraint\Constraint;
use ReflectionClass;
use ReflectionException;
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

    /** @var bool */
    protected $testPropertyDefaults;

    /** @var string */
    protected $additionalFailureDesc = '';

    public function __construct(bool $testPropertyDefaults)
    {
        parent::__construct();

        $this->accessorPairProvider    = new AccessorPairProvider();
        $this->constructorPairProvider = new ConstructorPairProvider();
        $this->valueProviderFactory    = new ValueProviderFactory();
        $this->testPropertyDefaults    = $testPropertyDefaults;
    }

    /**
     * @inheritDoc
     *
     * @param string $other
     *
     * @phpstan-param class-string $other
     * @throws Exception
     */
    public function matches($other): bool
    {
        if (class_exists($other) === false) {
            $this->fail($other, "Unable to load class");
        }

        try {
            // Inspect the provided class, and fetch all accessorPairs
            $accessorPairs    = $this->accessorPairProvider->getAccessorPairs(new ReflectionClass($other));
            $constructorPairs = $this->constructorPairProvider->getConstructorPairs(new ReflectionClass($other));

            // If requested, test the default values of all properties
            if ($this->testPropertyDefaults) {
                $this->testPropertyDefaults($accessorPairs);
            }

            // Test all accessorPairs
            foreach ($accessorPairs as $accessorPair) {
                $this->testAccessorPair($accessorPair);
            }

            // Test all constructorPairs
            foreach ($constructorPairs as $constructorPair) {
                $this->testConstructorPair($constructorPair);
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
     */
    protected function testPropertyDefaults(array $accessorPairs)
    {
        $this->additionalFailureDesc = 'Testing initial state of class.';

        foreach ($accessorPairs as $accessorPair) {
            $instance = $accessorPair->getClass()->newInstance();
            $accessorPair->getGetMethod()->invoke($instance);
        }
    }

    /**
     * Test all accessorPairs, by passing testvalues to the setter and expect the exact same value back from the getter.
     *
     * @throws ReflectionException
     * @throws Exception
     */
    protected function testAccessorPair(AccessorPair $accessorPair)
    {
        $this->additionalFailureDesc = 'Testing method ' . $accessorPair->getGetMethod()->getName() . ' and ' . $accessorPair->getSetMethod()->getName();

        // If the parameter has a default value:
        // assert that when calling the setter without a value provided, the getter returns the parameter default
        $parameter = $accessorPair->getSetMethod()->getParameters()[0];
        if ($parameter->isDefaultValueAvailable()) {
            $this->testOptionalParameter($accessorPair, $parameter);
        }

        $testValues = [];

        try {
            // Get list of test values based on the typehint
            $testValues = $this->getTestValues($accessorPair->getSetMethod(), $parameter);
        } catch (LogicException $e) {
            $this->fail($accessorPair->getClass()->getNamespaceName(), "It was not possible to get testValues for parameter: " . $parameter->getName());
        }

        // Test the accessorPair with the setup test values
        $this->testParameter($parameter, $accessorPair, $testValues);
    }

    /**
     * The setter's parameter has a default value
     * Call the setter without provider a parameter. Then call the getter and expect the default value return.
     *
     * @throws ReflectionException
     */
    protected function testOptionalParameter(AccessorPair $accessorPair, ReflectionParameter $parameter)
    {
        $expectedReturn = $parameter->getDefaultValue();

        // For "add" methods, we expect the getter to return an array
        if ($accessorPair->hasMultiGetter()) {
            $expectedReturn = [$expectedReturn];
        }

        // Create new instance, call the setter without providing a parameter. Call the getter, and we expect the default value
        $instance = $accessorPair->getClass()->newInstanceWithoutConstructor();
        $accessorPair->getSetMethod()->invoke($instance);
        $storedValue = $accessorPair->getGetMethod()->invoke($instance);

        if ($storedValue !== $expectedReturn) {
            $this->fail(
                $accessorPair->getClass()->getNamespaceName(),
                "Stored value (" . $this->exporter->export($storedValue) . ") does not match " .
                "default value (" . $this->exporter->export($expectedReturn) . ")"
            );
        }
    }

    /**
     * @param mixed[] $testValues
     */
    protected function testParameter(ReflectionParameter $parameter, AccessorPair $accessorPair, array $testValues)
    {
        $addedValues = [];
        $instance    = $accessorPair->getClass()->newInstanceWithoutConstructor();
        foreach ($testValues as $testValue) {
            // Pass testvalue to the instance
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
                    "Stored value (" . $this->exporter->export($storedValue) . ") does not match " .
                    "given value (" . $this->exporter->export($expectedReturn) . ")"
                );

                return;
            }
        }
    }

    /**
     * @throws Exception
     */
    protected function testConstructorPair(ConstructorPair $constructorPair)
    {
        $this->additionalFailureDesc = 'Testing method ' . $constructorPair->getGetMethod()->getName() .
            ' and constructor param ' . $constructorPair->getParameter()->getName();

        $class       = $constructorPair->getClass();
        $constructor = $class->getConstructor();

        // Create arguments array for constructor, with a single testvalue for all parameters
        $arguments = [];
        foreach ($constructor->getParameters() as $parameter) {
            $testValues  = $this->getTestValues($constructor, $parameter);
            $arguments[] = $testValues[0];
        }

        // Get all testvalues for the constructorPair parameter
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
                    "Stored value (" . $this->exporter->export($storedValue) . ") does not match " .
                    "given value (" . $this->exporter->export($expectedReturn) . ")"
                );

                return;
            }
        }
    }

    /**
     * @throws Exception
     */
    protected function getTestValues(ReflectionMethod $method, ReflectionParameter $parameter): array
    {
        $resolver = new TypehintResolver($method);
        $typehint = $resolver->getParamTypehint($parameter);

        return $this->valueProviderFactory->getProvider($typehint)->getValues();
    }
}
