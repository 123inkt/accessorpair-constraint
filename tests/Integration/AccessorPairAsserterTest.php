<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration;

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Runner\Version;
use ReflectionException;
use TypeError;

/**
 * @covers \DigitalRevolution\AccessorPairConstraint\Constraint\AccessorPairConstraint
 * @covers \DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPairProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPair
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPairProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\FalseType
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\TrueType
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\TrueProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\ResourceProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderList
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory
 */
class AccessorPairAsserterTest extends TestCase
{
    use AccessorPairAsserter;

    public function testMatchesIncorrectInput(): void
    {
        $exception = null;

        try {
            static::assertAccessorPairs('UnknownClass');
        } catch (ExpectationFailedException $exception) {
            static::assertSame("Unable to load class\nFailed asserting that 'UnknownClass' matches constraint.", $exception->getMessage());
        }

        static::assertNotNull($exception);
    }

    /**
     * @dataProvider successDataProvider
     *
     * @param object $class
     */
    public function testMatchesSuccess($class): void
    {
        static::assertAccessorPairs(get_class($class));
    }

    /**
     * @dataProvider successInitialStateDataProvider
     *
     * @param object $class
     */
    public function testMatchesSuccessInitialState($class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertPropertyDefaults(true));
    }

    /**
     * When turning off the propertyDefaultCheck, we can safely pass classes we know will fail the constraint
     *
     * @dataProvider failureInitialStateDataProvider
     *
     * @param object $class
     */
    public function testExcludingInitialStateCheck($class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertPropertyDefaults(false));
    }

    /**
     * @dataProvider successConstructorDataProvider
     *
     * @param object $class
     */
    public function testMatchesSuccessConstructorPair($class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertConstructor(true));
    }

    /**
     * When turning off the constructorPairCheck, we can safely pass classes we know will fail the constraint
     *
     * @dataProvider failureConstructorDataProvider
     *
     * @param object $class
     */
    public function testExcludingConstructorPair($class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertConstructor(false));
    }

    /**
     * @dataProvider failureDataProvider
     *
     * @param object $class
     */
    public function testMatchesFailureState($class): void
    {
        $this->expectException(ExpectationFailedException::class);
        static::assertAccessorPairs(get_class($class));
    }

    /**
     * @dataProvider failureInitialStateDataProvider
     *
     * @param object $class
     */
    public function testMatchesFailureInitialState($class): void
    {
        $exception = null;
        try {
            static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertPropertyDefaults(true));
        } catch (TypeError $exception) {
            // Compatibility for both PHPUnit 8 and 9
            $pattern = '/Return value of .*?::.*?\(\) must be of the type .*?, .*? returned/';
            if (version_compare(Version::id(), '9.0.0', '>=')) {
                static::assertMatchesRegularExpression($pattern, $exception->getMessage());
            } else {
                static::assertRegExp($pattern, $exception->getMessage());
            }
        }

        static::assertNotNull($exception);
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public function successDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/success/Regular', __NAMESPACE__ . "\data\success\Regular");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public function failureDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/failure/Regular', __NAMESPACE__ . "\data\\failure\Regular");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public function successInitialStateDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/success/InitialState', __NAMESPACE__ . "\data\success\InitialState");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public function failureInitialStateDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/failure/InitialState', __NAMESPACE__ . "\data\\failure\InitialState");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public function successConstructorDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/success/Regular/Constructor', __NAMESPACE__ . "\data\\success\Regular\\Constructor");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public function failureConstructorDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/failure/Regular/Constructor', __NAMESPACE__ . "\data\\failure\Regular\\Constructor");
    }
}
