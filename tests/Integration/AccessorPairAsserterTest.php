<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration;

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use DigitalRevolution\AccessorPairConstraint\Constraint\AccessorPairConstraint;
use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayShapeProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IntersectionProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\TrueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\NativeValueProviderFactory;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ConstExpressionProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\DirectValueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LowercaseStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NonEmptyValueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\TraitStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\PseudoValueProviderFactory;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\ResourceProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderList;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\CustomConstructorParameters;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\FinalClass;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\IntersectionClassProperty;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\IntersectionInterfaceProperty;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\SetterTransformer;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\UnionNullableProperty;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual\UnionProperty;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\ExpectationFailedException;
use ReflectionException;
use TypeError;

#[CoversClass(AccessorPairAsserter::class)]
#[CoversClass(AccessorPairConstraint::class)]
#[UsesClass(ConstraintConfig::class)]
#[UsesClass(AbstractMethodPair::class)]
#[UsesClass(ClassMethodProvider::class)]
#[UsesClass(AccessorPair::class)]
#[UsesClass(AccessorPairProvider::class)]
#[UsesClass(ConstructorPair::class)]
#[UsesClass(ConstructorPairProvider::class)]
#[UsesClass(PhpDocParser::class)]
#[UsesClass(TypehintResolver::class)]
#[UsesClass(ArrayProvider::class)]
#[UsesClass(ArrayShapeProvider::class)]
#[UsesClass(CallableProvider::class)]
#[UsesClass(InstanceProvider::class)]
#[UsesClass(IntersectionProvider::class)]
#[UsesClass(IterableProvider::class)]
#[UsesClass(ObjectProvider::class)]
#[UsesClass(TrueProvider::class)]
#[UsesClass(FalseProvider::class)]
#[UsesClass(CallableStringProvider::class)]
#[UsesClass(ClassStringProvider::class)]
#[UsesClass(DirectValueProvider::class)]
#[UsesClass(HtmlEscapedStringProvider::class)]
#[UsesClass(ListProvider::class)]
#[UsesClass(LiteralStringProvider::class)]
#[UsesClass(LowercaseStringProvider::class)]
#[UsesClass(NonEmptyValueProvider::class)]
#[UsesClass(NumericStringProvider::class)]
#[UsesClass(TraitStringProvider::class)]
#[UsesClass(BoolProvider::class)]
#[UsesClass(FloatProvider::class)]
#[UsesClass(IntProvider::class)]
#[UsesClass(StringProvider::class)]
#[UsesClass(NullProvider::class)]
#[UsesClass(ResourceProvider::class)]
#[UsesClass(NativeValueProviderFactory::class)]
#[UsesClass(PseudoValueProviderFactory::class)]
#[UsesClass(ValueProviderList::class)]
#[UsesClass(ValueProviderFactory::class)]
#[UsesClass(ConstExpressionProvider::class)]
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

    #[DataProvider('successDataProvider')]
    public function testMatchesSuccess(object $class): void
    {
        static::assertAccessorPairs(get_class($class));
    }

    #[DataProvider('successInitialStateDataProvider')]
    public function testMatchesSuccessInitialState(object $class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertPropertyDefaults(true));
    }

    #[DataProvider('successInitialStateDataProvider')]
    public function testMatchesSuccessInitialStateWithDefaultMethod(object $class): void
    {
        static::assertAccessorPropertyDefaults(get_class($class));
    }

    /**
     * When turning off the propertyDefaultCheck, we can safely pass classes we know will fail the constraint
     */
    #[DataProvider('failureInitialStateDataProvider')]
    public function testExcludingInitialStateCheck(object $class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertPropertyDefaults(false));
    }

    #[DataProvider('successConstructorDataProvider')]
    public function testMatchesSuccessConstructorPair(object $class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertConstructor(true));
    }

    /**
     * When turning off the constructorPairCheck, we can safely pass classes we know will fail the constraint
     */
    #[DataProvider('failureConstructorDataProvider')]
    public function testExcludingConstructorPair(object $class): void
    {
        static::assertAccessorPairs(get_class($class), (new ConstraintConfig())->setAssertConstructor(false));
    }

    #[DataProvider('failureDataProvider')]
    public function testMatchesFailureState(object $class): void
    {
        $this->expectException(ExpectationFailedException::class);
        static::assertAccessorPairs(get_class($class));
    }

    #[DataProvider('failureInitialStateDataProvider')]
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

    #[RequiresPhp('>=8.0')]
    public function testUnionProperty(): void
    {
        // Test a method with a union typehint: A|B
        static::assertAccessorPairs(UnionProperty::class);
        static::assertAccessorPairs(UnionNullableProperty::class);
    }

    #[RequiresPhp('>=8.1')]
    public function testIntersectionInterfaceProperty(): void
    {
        // Test a method with an intersection typehint: A&B
        static::assertAccessorPairs(IntersectionInterfaceProperty::class);
    }

    #[RequiresPhp('>=8.1')]
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
