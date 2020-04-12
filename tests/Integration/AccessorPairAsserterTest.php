<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration;

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Exception;
use Generator;
use PHPUnit\Framework\ExpectationFailedException;
use TypeError;

/**
 * @covers \DigitalRevolution\AccessorPairConstraint\Constraint\AccessorPairConstraint
 * @covers \DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter
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

    public function testMatchesIncorrectInput()
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
    public function testMatchesSuccess($class)
    {
        static::assertAccessorPairs(get_class($class));
    }

    /**
     * @dataProvider successInitialStateDataProvider
     *
     * @param object $class
     */
    public function testMatchesSuccessInitialState($class)
    {
        static::assertAccessorPairs(get_class($class), true);
    }

    /**
     * @dataProvider failureStateDataProvider
     *
     * @param object $class
     */
    public function testMatchesFailureState($class)
    {
        $exception = null;
        try {
            static::assertAccessorPairs(get_class($class));
        } catch (Exception $exception) {
        }

        static::assertNotNull($exception);
    }

    /**
     * @dataProvider failureInitialStateDataProvider
     *
     * @param object $class
     */
    public function testMatchesFailureInitialState($class)
    {
        $exception = null;
        try {
            static::assertAccessorPairs(get_class($class), true);
        } catch (TypeError $exception) {
            static::assertRegExp('/Return value of .*?::.*?\(\) must be of the type .*?, .*? returned/', $exception->getMessage());
        }

        static::assertNotNull($exception);
    }

    public function successDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/success/Regular', __NAMESPACE__ . "\data\success\Regular");
    }

    public function successInitialStateDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/success/InitialState', __NAMESPACE__ . "\data\success\InitialState");
    }

    public function failureStateDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/failure/Regular', __NAMESPACE__ . "\data\\failure\Regular");
    }

    public function failureInitialStateDataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data/failure/InitialState', __NAMESPACE__ . "\data\\failure\InitialState");
    }
}
