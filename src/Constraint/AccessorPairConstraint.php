<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\MethodPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\MethodPairProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory;
use Exception;
use LogicException;
use PHPUnit\Framework\Constraint\Constraint;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class AccessorPairConstraint extends Constraint
{
    /** @var MethodPairProvider */
    protected $methodPairProvider;

    /** @var ValueProviderFactory */
    protected $valueProviderFactory;

    /** @var bool */
    protected $testPropertyDefaults;

    /** @var string */
    protected $additionalFailureDesc = '';

    public function __construct(bool $testPropertyDefaults)
    {
        parent::__construct();

        $this->methodPairProvider   = new MethodPairProvider();
        $this->valueProviderFactory = new ValueProviderFactory();
        $this->testPropertyDefaults   = $testPropertyDefaults;
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
            // Inspect the provided class, and fetch all methodPairs
            $methodPairs = $this->methodPairProvider->getMethodPairs(new ReflectionClass($other));

            // If requested, test the default values of all properties
            if ($this->testPropertyDefaults) {
                $this->testPropertyDefaults($methodPairs);
            }

            // Test all methodPairs
            foreach ($methodPairs as $methodPair) {
                $this->testMethodPair($methodPair);
            }
        } catch (LogicException $e) {
            $this->fail($other, "Unable to run constraint on class. " . $e->getMessage());
        }

        return true;
    }

    /**
     * Assert that all the class properties have the correct default values setup.
     * Calling all getter methods should not throw any TypeErrors for example, without calling a setter first.
     *
     * @param MethodPair[] $methodPairs
     */
    protected function testPropertyDefaults(array $methodPairs)
    {
        $this->additionalFailureDesc = 'Testing initial state of class.';

        foreach ($methodPairs as $methodPair) {
            $instance = $methodPair->getClass()->newInstance();
            $methodPair->getGetMethod()->invoke($instance);
        }
    }

    /**
     * Test all methodPairs, by passing testvalues to the setter and expect the exact same value back from the getter.
     *
     * @throws ReflectionException
     * @throws Exception
     */
    protected function testMethodPair(MethodPair $methodPair)
    {
        $this->additionalFailureDesc = 'Testing method ' . $methodPair->getGetMethod()->getName() . ' and ' . $methodPair->getSetMethod()->getName();

        // If the parameter has a default value:
        // assert that when calling the setter without a value provided, the getter returns the parameter default
        $parameter = $methodPair->getSetMethod()->getParameters()[0];
        if ($parameter->isDefaultValueAvailable()) {
            $this->testOptionalParameter($methodPair, $parameter);
        }

        // Get the typehint from the parameter/setter method
        $resolver   = new TypehintResolver($methodPair->getSetMethod());
        $typehint   = $resolver->getParamTypehint($parameter);
        $testValues = [];

        try {
            // Get list of test values based on the typehint
            $testValues = $this->valueProviderFactory->getProvider($typehint)->getValues();
        } catch (LogicException $e) {
            $this->fail($methodPair->getClass()->getNamespaceName(), "It was not possible to get a valueprovider for the typehint: " . $typehint);
        }

        // Test the methodPair with the setup test values
        $this->testParameter($parameter, $methodPair, $testValues);
    }

    /**
     * The setter's parameter has a default value
     * Call the setter without provider a parameter. Then call the getter and expect the default value return.
     *
     * @throws ReflectionException
     */
    protected function testOptionalParameter(MethodPair $methodPair, ReflectionParameter $parameter)
    {
        $expectedReturn = $parameter->getDefaultValue();

        // For "add" methods, we expect the getter to return an array
        if ($methodPair->hasMultiGetter()) {
            $expectedReturn = [$expectedReturn];
        }

        // Create new instance, call the setter without providing a parameter. Call the getter, and we expect the default value
        $instance = $methodPair->getClass()->newInstance();
        $methodPair->getSetMethod()->invoke($instance);
        $storedValue = $methodPair->getGetMethod()->invoke($instance);

        if ($storedValue !== $expectedReturn) {
            $this->fail(
                $methodPair->getClass()->getNamespaceName(),
                "Stored value (" . $this->exporter->export($storedValue) . ") does not match " .
                "default value (" . $this->exporter->export($expectedReturn) . ")"
            );
        }
    }

    /**
     * @param mixed[] $testValues
     */
    protected function testParameter(ReflectionParameter $parameter, MethodPair $methodPair, array $testValues)
    {
        $addedValues = [];
        $instance    = $methodPair->getClass()->newInstance();
        foreach ($testValues as $testValue) {
            // Pass testvalue to the instance
            $methodPair->getSetMethod()->invoke($instance, $testValue);
            $addedValues[] = $testValue;

            // Retrieve the stored value, should be exactly the same
            $storedValue = $methodPair->getGetMethod()->invoke($instance);

            if ($methodPair->hasMultiGetter()) {
                // If the methodPair has an "add" method, the getter should return All previously passed values
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
                    $methodPair->getClass()->getNamespaceName(),
                    "Stored value (" . $this->exporter->export($storedValue) . ") does not match " .
                    "given value (" . $this->exporter->export($expectedReturn) . ")"
                );

                return;
            }
        }
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
}
