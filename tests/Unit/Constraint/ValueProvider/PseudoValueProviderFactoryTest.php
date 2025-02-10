<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
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
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderList;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\PseudoTypes\CallableString;
use phpDocumentor\Reflection\PseudoTypes\ConstExpression;
use phpDocumentor\Reflection\PseudoTypes\FloatValue;
use phpDocumentor\Reflection\PseudoTypes\HtmlEscapedString;
use phpDocumentor\Reflection\PseudoTypes\IntegerRange;
use phpDocumentor\Reflection\PseudoTypes\IntegerValue;
use phpDocumentor\Reflection\PseudoTypes\List_;
use phpDocumentor\Reflection\PseudoTypes\LiteralString;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;
use phpDocumentor\Reflection\PseudoTypes\NegativeInteger;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyList;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyLowercaseString;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyString;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use phpDocumentor\Reflection\PseudoTypes\NumericString;
use phpDocumentor\Reflection\PseudoTypes\PositiveInteger;
use phpDocumentor\Reflection\PseudoTypes\StringValue;
use phpDocumentor\Reflection\PseudoTypes\TraitString;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\ArrayKey;
use phpDocumentor\Reflection\Types\ClassString;
use phpDocumentor\Reflection\Types\Object_;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use stdClass;

#[CoversClass(PseudoValueProviderFactory::class)]
#[UsesClass(ArrayProvider::class)]
#[UsesClass(CallableProvider::class)]
#[UsesClass(IterableProvider::class)]
#[UsesClass(ObjectProvider::class)]
#[UsesClass(InstanceProvider::class)]
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
#[UsesClass(ValueProviderList::class)]
#[UsesClass(NativeValueProviderFactory::class)]
#[UsesClass(ValueProviderFactory::class)]
#[UsesClass(ConstExpressionProvider::class)]
class PseudoValueProviderFactoryTest extends TestCase
{
    #[DataProvider('pseudoTypeProvider')]
    public function testGetProvider(Type $type, ValueProvider $expectedProvider): void
    {
        $providerFactory = new PseudoValueProviderFactory(new ValueProviderFactory());
        static::assertEquals($expectedProvider, $providerFactory->getProvider($type));
    }

    public function testGetProviderUnknown(): void
    {
        $providerFactory = new PseudoValueProviderFactory($this->createMock(ValueProviderFactory::class));

        static::assertNull(
            $providerFactory->getProvider(
                new class implements Type {
                    public function __toString(): string
                    {
                        return 'unknown';
                    }
                }
            )
        );
    }

    /**
     * @return Generator<string, array{0: Type, 1: ValueProvider}>
     */
    public static function pseudoTypeProvider(): Generator
    {
        yield "PseudoType ArrayKey" => [new ArrayKey(), new ValueProviderList(new StringProvider(new NumericStringProvider(new IntProvider())), new IntProvider())];
        yield "PseudoType ClassString" => [new ClassString(), new ClassStringProvider()];
        yield "PseudoType ClassString Fqsen" => [
            new ClassString(new Fqsen('\\' . ValueProvider::class)),
            new ClassStringProvider('\\' . ValueProvider::class)
        ];
        yield "PseudoType CallableString" => [new CallableString(), new CallableStringProvider()];
        yield "PseudoType FloatValue" => [new FloatValue(1.0), new DirectValueProvider(new FloatValue(1.0))];
        yield "PseudoType IntegerValue" => [new IntegerValue(1), new DirectValueProvider(new IntegerValue(1))];
        yield "PseudoType StringValue" => [new StringValue('foo'), new DirectValueProvider(new StringValue('foo'))];
        yield "PseudoType HtmlEscapedString" => [new HtmlEscapedString(), new HtmlEscapedStringProvider()];
        yield "PseudoType IntegerRange" => [new IntegerRange('0', '5'), new IntProvider(0, 5)];
        yield "PseudoType List" => [new List_(), new ListProvider(self::getMixedProvider())];
        yield "PseudoType NonEmptyList" => [new NonEmptyList(), new NonEmptyValueProvider(new ListProvider(self::getMixedProvider()))];
        yield "PseudoType LiteralString" => [new LiteralString(), new LiteralStringProvider()];
        yield "PseudoType LowercaseString" => [new LowercaseString(), new LowercaseStringProvider(new StringProvider(new NumericStringProvider(new IntProvider())))];
        yield "PseudoType NegativeInteger" => [new NegativeInteger(), new IntProvider(PHP_INT_MIN, -1)];
        yield "PseudoType NonEmptyLowercaseString" => [
            new NonEmptyLowercaseString(),
            new NonEmptyValueProvider(new LowercaseStringProvider(new StringProvider(new NumericStringProvider(new IntProvider()))))
        ];
        yield "PseudoType NonEmptyString" => [new NonEmptyString(), new NonEmptyValueProvider(new StringProvider(new NumericStringProvider(new IntProvider())))];
        yield "PseudoType Numeric" => [
            new Numeric_(),
            new ValueProviderList(new NumericStringProvider(new IntProvider()), new IntProvider(), new FloatProvider(new IntProvider()))
        ];
        yield "PseudoType NumericString" => [new NumericString(), new NumericStringProvider(new IntProvider())];
        yield "PseudoType PositiveInteger" => [new PositiveInteger(), new IntProvider(1, PHP_INT_MAX)];
        yield "PseudoType TraitString" => [new TraitString(), new TraitStringProvider()];
        yield "PseudoType ConstExpression" => [
            new ConstExpression(new Object_(new Fqsen("\\" . stdClass::class)), "CONST_*"),
            new ConstExpressionProvider(new Object_(new Fqsen("\\" . stdClass::class)), "CONST_*", null)
        ];
    }

    private static function getMixedProvider(): ValueProviderList
    {
        return new ValueProviderList(
            new StringProvider(new NumericStringProvider(new IntProvider())),
            new BoolProvider(),
            new IntProvider(),
            new FloatProvider(new IntProvider()),
            new ArrayProvider(),
            new ObjectProvider(),
            new CallableProvider(),
            new NullProvider()
        );
    }
}
