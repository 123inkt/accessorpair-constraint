<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayShapeProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\TrueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\NativeValueProviderFactory;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider;
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
use phpDocumentor\Reflection\PseudoTypes\ArrayShape;
use phpDocumentor\Reflection\PseudoTypes\ArrayShapeItem;
use phpDocumentor\Reflection\PseudoTypes\False_;
use phpDocumentor\Reflection\PseudoTypes\True_;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Callable_;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Iterable_;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Resource_;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(NativeValueProviderFactory::class)]
#[UsesClass(ArrayProvider::class)]
#[UsesClass(ArrayShapeProvider::class)]
#[UsesClass(CallableProvider::class)]
#[UsesClass(IterableProvider::class)]
#[UsesClass(ObjectProvider::class)]
#[UsesClass(InstanceProvider::class)]
#[UsesClass(TrueProvider::class)]
#[UsesClass(FalseProvider::class)]
#[UsesClass(CallableStringProvider::class)]
#[UsesClass(ClassStringProvider::class)]
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
#[UsesClass(PseudoValueProviderFactory::class)]
#[UsesClass(ValueProviderFactory::class)]
class NativeValueProviderFactoryTest extends TestCase
{
    /**
     * @return Generator<string, array{0: Type, 1: ValueProvider}>
     */
    public static function nativeTypeProvider(): Generator
    {
        yield "NativeType Array" => [
            new Array_(),
            new ArrayProvider(
                self::getMixedProvider(),
                new ValueProviderList(new StringProvider(new NumericStringProvider(new IntProvider())), new IntProvider())
            )
        ];
        yield "NativeType ArrayShape" => [
            new ArrayShape(new ArrayShapeItem("foo", new String_(), false)),
            new ArrayShapeProvider(["foo" => new StringProvider(new NumericStringProvider(new IntProvider()))])
        ];
        yield "NativeType Callable" => [new Callable_(), new CallableProvider()];
        yield "NativeType Iterable" => [new Iterable_(), new IterableProvider()];
        yield "NativeType Object" => [new Object_(), new ObjectProvider()];
        yield "NativeType True" => [new True_(), new TrueProvider()];
        yield "NativeType False" => [new False_(), new FalseProvider()];
        yield "NativeType Boolean" => [new Boolean(), new BoolProvider()];
        yield "NativeType Float" => [new Float_(), new FloatProvider(new IntProvider())];
        yield "NativeType Integer" => [new Integer(), new IntProvider()];
        yield "NativeType String" => [new String_(), new StringProvider(new NumericStringProvider(new IntProvider()))];
        yield "NativeType Null" => [new Null_(), new NullProvider()];
        yield "NativeType Resource" => [new Resource_(), new ResourceProvider()];
        yield "NativeType Mixed" => [new Mixed_(), self::getMixedProvider()];
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

    #[DataProvider('nativeTypeProvider')]
    public function testGetProvider(Type $type, ValueProvider $expectedProvider): void
    {
        $providerFactory = new NativeValueProviderFactory(new ValueProviderFactory());
        static::assertEquals($expectedProvider, $providerFactory->getProvider($type));
    }

    public function testGetProviderUnknown(): void
    {
        $providerFactory = new NativeValueProviderFactory($this->createMock(ValueProviderFactory::class));

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
}
