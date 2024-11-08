<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration;

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\CustomConstructorParameters;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\FinalClass;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\IntersectionClassProperty;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\IntersectionInterfaceProperty;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\SetterTransformer;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\UnionNullableProperty;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\UnionProperty;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;
use PHPUnit\Framework\ExpectationFailedException;
use ReflectionException;
use TypeError;

/**
 * @covers \DigitalRevolution\AccessorPairConstraint\Constraint\AccessorPairConstraint
 * @covers \DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPairProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPair
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPairProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayShapeProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IntersectionProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\TrueProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\DirectValueProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LowercaseStringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NonEmptyValueProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\TraitStringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\ResourceProvider
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\NativeValueProviderFactory
 * @uses   \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\PseudoValueProviderFactory
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
     */
    public function testMatchesSuccess(object $class): void
    {
        static::assertAccessorPairs(get_class($class));
    }

    /**
     * @dataProvider successInitialStateDataProvider
     */
    public function testMatchesSuccessInitialState(object $class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertPropertyDefaults(true));
    }

    /**
     * @dataProvider successInitialStateDataProvider
     */
    public function testMatchesSuccessInitialStateWithDefaultMethod(object $class): void
    {
        static::assertAccessorPropertyDefaults(get_class($class));
    }

    /**
     * When turning off the propertyDefaultCheck, we can safely pass classes we know will fail the constraint
     * @dataProvider failureInitialStateDataProvider
     */
    public function testExcludingInitialStateCheck(object $class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertPropertyDefaults(false));
    }

    /**
     * @dataProvider successConstructorDataProvider
     */
    public function testMatchesSuccessConstructorPair(object $class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertConstructor(true));
    }

    /**
     * When turning off the constructorPairCheck, we can safely pass classes we know will fail the constraint
     * @dataProvider failureConstructorDataProvider
     */
    public function testExcludingConstructorPair(object $class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertConstructor(false));
    }

    /**
     * @dataProvider failureDataProvider
     */
    public function testMatchesFailureState(object $class): void
    {
        $this->expectException(ExpectationFailedException::class);
        static::assertAccessorPairs(get_class($class));
    }

    /**
     * @dataProvider failureInitialStateDataProvider
     */
    public function testMatchesFailureInitialState(object $class): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessageMatches('/Return value (of .*?::.*?\(\) )?must be of (the )?type .*?, .*? returned/');
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertPropertyDefaults(true));
    }

    public function testCustomConstructorTestFailure(): void
    {
        // The test should fail because the SetterTransformer mock returns a different
        // mock object in the setter.
        $this->expectException(ExpectationFailedException::class);
        static::assertAccessorPairs(CustomConstructorParameters::class);
    }

    public function testCustomConstructorTest(): void
    {
        $config = new ConstraintConfig();
        $config->setConstructorCallback(static function (): array {
            // Prevent the SetterTransformer from being mocked by explicitly controlling
            // it's creation.
            return [
                new SetterTransformer(),
            ];
        });

        static::assertAccessorPairs(CustomConstructorParameters::class, $config);
    }

    /**
     * @requires PHP >= 8.0
     */
    public function testUnionProperty(): void
    {
        // Test a method with a union typehint: A|B
        static::assertAccessorPairs(UnionProperty::class);
        static::assertAccessorPairs(UnionNullableProperty::class);
    }

    /**
     * @requires PHP >= 8.1
     */
    public function testIntersectionInterfaceProperty(): void
    {
        // Test a method with an intersection typehint: A&B
        static::assertAccessorPairs(IntersectionInterfaceProperty::class);
    }

    /**
     * @requires PHP >= 8.1
     */
    public function testIntersectionClassProperty(): void
    {
        // Test a method with an intersection typehint: A&B
        static::assertAccessorPairs(IntersectionClassProperty::class);
    }

    public function testFinalClassWithCustomValueProvider(): void
    {
        $config = new ConstraintConfig();
        $config->setValueProvider(static fn(string $class) => $class === FinalClass::class ? new FinalClass() : null);

        static::assertAccessorPairs(FinalClass::class, $config);
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function successDataProvider(): Generator
    {
        yield from static::getClassDataProvider(__DIR__ . '/data/success/Regular', __NAMESPACE__ . "\data\success\Regular");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function failureDataProvider(): Generator
    {
        yield from static::getClassDataProvider(__DIR__ . '/data/failure/Regular', __NAMESPACE__ . "\data\\failure\Regular");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function successInitialStateDataProvider(): Generator
    {
        yield from static::getClassDataProvider(__DIR__ . '/data/success/InitialState', __NAMESPACE__ . "\data\success\InitialState");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function failureInitialStateDataProvider(): Generator
    {
        yield from static::getClassDataProvider(__DIR__ . '/data/failure/InitialState', __NAMESPACE__ . "\data\\failure\InitialState");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function successConstructorDataProvider(): Generator
    {
        yield from static::getClassDataProvider(__DIR__ . '/data/success/Regular/Constructor', __NAMESPACE__ . "\data\\success\Regular\\Constructor");
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function failureConstructorDataProvider(): Generator
    {
        yield from static::getClassDataProvider(__DIR__ . '/data/failure/Regular/Constructor', __NAMESPACE__ . "\data\\failure\Regular\\Constructor");
    }
}
