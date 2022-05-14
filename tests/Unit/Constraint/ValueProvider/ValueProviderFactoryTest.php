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
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LowercaseStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NonEmptyStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\TraitStringProvider;
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
use LogicException;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\PseudoTypes\CallableString;
use phpDocumentor\Reflection\PseudoTypes\False_;
use phpDocumentor\Reflection\PseudoTypes\HtmlEscapedString;
use phpDocumentor\Reflection\PseudoTypes\IntegerRange;
use phpDocumentor\Reflection\PseudoTypes\List_;
use phpDocumentor\Reflection\PseudoTypes\LiteralString;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;
use phpDocumentor\Reflection\PseudoTypes\NegativeInteger;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyLowercaseString;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyString;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use phpDocumentor\Reflection\PseudoTypes\NumericString;
use phpDocumentor\Reflection\PseudoTypes\PositiveInteger;
use phpDocumentor\Reflection\PseudoTypes\TraitString;
use phpDocumentor\Reflection\PseudoTypes\True_;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\ArrayKey;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Callable_;
use phpDocumentor\Reflection\Types\ClassString;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Iterable_;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Resource_;
use phpDocumentor\Reflection\Types\String_;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\TrueProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LowercaseStringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NonEmptyStringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\TraitStringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\ResourceProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderList
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ValueProviderFactoryTest extends TestCase
{
    /**
     * @dataProvider nativeTypeProvider
     * @dataProvider pseudoTypeProvider
     * @dataProvider dataProvider
     * @covers ::getProvider
     * @covers ::getNativeTypeProvider
     * @covers ::getPseudoProvider
     * @covers ::getMixedProvider
     * @covers ::getProviders
     */
    public function testGetProvider(Type $type, ValueProvider $expectedProvider): void
    {
        $providerFactory = new ValueProviderFactory();
        static::assertEquals($expectedProvider, $providerFactory->getProvider($type));
    }

    /**
     * @covers ::getProvider
     * @covers ::getNativeTypeProvider
     * @covers ::getPseudoProvider
     */
    public function testGetProviderUnknown(): void
    {
        $providerFactory = new ValueProviderFactory();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("No value provider found for typehint: unknown");
        $providerFactory->getProvider(
            new class implements Type {
                public function __toString(): string
                {
                    return 'unknown';
                }
            }
        );
    }

    /**
     * @return Generator<string, array{0: Type, 1: ValueProvider}>
     */
    public function nativeTypeProvider(): Generator
    {
        yield "NativeType Array" => [
            new Array_(),
            new ArrayProvider($this->getMixedProvider(), new ValueProviderList(new StringProvider(), new IntProvider()))
        ];
        yield "NativeType Callable" => [new Callable_(), new CallableProvider()];
        yield "NativeType Iterable" => [new Iterable_(), new IterableProvider()];
        yield "NativeType Object" => [new Object_(), new ObjectProvider()];
        yield "NativeType True" => [new True_(), new TrueProvider()];
        yield "NativeType False" => [new False_(), new FalseProvider()];
        yield "NativeType Boolean" => [new Boolean(), new BoolProvider()];
        yield "NativeType Float" => [new Float_(), new FloatProvider(new IntProvider())];
        yield "NativeType Integer" => [new Integer(), new IntProvider()];
        yield "NativeType String" => [new String_(), new StringProvider()];
        yield "NativeType Null" => [new Null_(), new NullProvider()];
        yield "NativeType Resource" => [new Resource_(), new ResourceProvider()];
        yield "NativeType Mixed" => [new Mixed_(), $this->getMixedProvider()];
    }

    /**
     * @return Generator<string, array{0: Type, 1: ValueProvider}>
     */
    public function pseudoTypeProvider(): Generator
    {
        yield "PseudoType ArrayKey" => [new ArrayKey(), new ValueProviderList(new StringProvider(), new IntProvider())];
        yield "PseudoType ClassString" => [new ClassString(), new ClassStringProvider()];
        yield "PseudoType ClassString Fqsen" => [
            new ClassString(new Fqsen('\\' . ValueProvider::class)),
            new ClassStringProvider('\\' . ValueProvider::class)
        ];
        yield "PseudoType CallableString" => [new CallableString(), new CallableStringProvider()];
        yield "PseudoType HtmlEscapedString" => [new HtmlEscapedString(), new HtmlEscapedStringProvider()];
        yield "PseudoType IntegerRange" => [new IntegerRange('0', '5'), new IntProvider(0, 5)];
        yield "PseudoType List" => [new List_(), new ListProvider($this->getMixedProvider())];
        yield "PseudoType LiteralString" => [new LiteralString(), new LiteralStringProvider()];
        yield "PseudoType LowercaseString" => [new LowercaseString(), new LowercaseStringProvider(new StringProvider())];
        yield "PseudoType NegativeInteger" => [new NegativeInteger(), new IntProvider(PHP_INT_MIN, -1)];
        yield "PseudoType NonEmptyLowercaseString" => [
            new NonEmptyLowercaseString(),
            new NonEmptyStringProvider(new LowercaseStringProvider(new StringProvider()))
        ];
        yield "PseudoType NonEmptyString" => [new NonEmptyString(), new NonEmptyStringProvider(new StringProvider())];
        yield "PseudoType Numeric" => [
            new Numeric_(),
            new ValueProviderList(new NumericStringProvider(), new IntProvider(), new FloatProvider(new IntProvider()))
        ];
        yield "PseudoType NumericString" => [new NumericString(), new NumericStringProvider()];
        yield "PseudoType PositiveInteger" => [new PositiveInteger(), new IntProvider(1, PHP_INT_MAX)];
        yield "PseudoType TraitString" => [new TraitString(), new TraitStringProvider()];
    }

    /**
     * @return Generator<string, array{0: Type, 1: ValueProvider}>
     */
    public function dataProvider(): Generator
    {
        yield 'Union type' => [new Compound([new Integer(), new String_()]), new ValueProviderList(new IntProvider(), new StringProvider())];
        yield 'Nullable type' => [new Nullable(new Integer()), new ValueProviderList(new NullProvider(), new IntProvider())];
        yield 'Typed array' => [
            new Array_(new Integer()),
            new ArrayProvider(new IntProvider(), new ValueProviderList(new StringProvider(), new IntProvider()))
        ];
        yield 'Interface typehint' => [new Object_(new Fqsen('\\' . ValueProvider::class)), new InstanceProvider(ValueProvider::class)];
    }

    private function getMixedProvider(): ValueProviderList
    {
        return new ValueProviderList(
            new StringProvider(),
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
