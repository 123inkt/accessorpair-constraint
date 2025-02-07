<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider;

use Countable;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
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
use Iterator;
use LogicException;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\PseudoTypes\LiteralString;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Intersection;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\Object_;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(ValueProviderFactory::class)]
#[UsesClass(ArrayProvider::class)]
#[UsesClass(CallableProvider::class)]
#[UsesClass(IterableProvider::class)]
#[UsesClass(ObjectProvider::class)]
#[UsesClass(InstanceProvider::class)]
#[UsesClass(IntersectionProvider::class)]
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
#[UsesClass(NativeValueProviderFactory::class)]
class ValueProviderFactoryTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testGetProvider(Type $type, ValueProvider $expectedProvider): void
    {
        $providerFactory = new ValueProviderFactory();
        static::assertEquals($expectedProvider, $providerFactory->getProvider($type));
    }

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
    public static function dataProvider(): Generator
    {
        yield 'Intersection type' => [
            new Intersection([new Object_(new Fqsen('\\' . Iterator::class)), new Object_(new Fqsen('\\' . Countable::class))]),
            new IntersectionProvider([new Object_(new Fqsen('\\' . Iterator::class)), new Object_(new Fqsen('\\' . Countable::class))])
        ];
        yield 'Union type' => [
            new Compound([new Integer(), new LiteralString()]),
            new ValueProviderList(new IntProvider(), new LiteralStringProvider())
        ];
        yield 'Nullable type' => [new Nullable(new Integer()), new ValueProviderList(new NullProvider(), new IntProvider())];
        yield 'Typed array' => [
            new Array_(new Integer()),
            new ArrayProvider(new IntProvider(), new ValueProviderList(new StringProvider(), new IntProvider()))
        ];
        yield 'Interface typehint' => [new Object_(new Fqsen('\\' . ValueProvider::class)), new InstanceProvider(ValueProvider::class)];
    }
}
