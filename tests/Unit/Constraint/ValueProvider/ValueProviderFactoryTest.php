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
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider;
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
use phpDocumentor\Reflection\PseudoTypes\LiteralString;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory
 * @covers ::__construct
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
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\PseudoValueProviderFactory
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\NativeValueProviderFactory
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ValueProviderFactoryTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @covers ::getProvider
     * @covers ::getProviders
     */
    public function testGetProvider(Type $type, ValueProvider $expectedProvider): void
    {
        $providerFactory = new ValueProviderFactory();
        static::assertEquals($expectedProvider, $providerFactory->getProvider($type));
    }

    /**
     * @covers ::getProvider
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
    public static function dataProvider(): Generator
    {
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
