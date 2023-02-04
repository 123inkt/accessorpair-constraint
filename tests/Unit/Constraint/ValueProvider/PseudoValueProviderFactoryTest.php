<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LowercaseStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NonEmptyStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\TraitStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\PseudoValueProviderFactory;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderList;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\PseudoTypes\CallableString;
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
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\ArrayKey;
use phpDocumentor\Reflection\Types\ClassString;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\PseudoValueProviderFactory
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
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\NativeValueProviderFactory
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderFactory
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PseudoValueProviderFactoryTest extends TestCase
{
    /**
     * @dataProvider pseudoTypeProvider
     * @covers ::getProvider
     * @covers ::getPseudoStringProvider
     */
    public function testGetProvider(Type $type, ValueProvider $expectedProvider): void
    {
        $providerFactory = new PseudoValueProviderFactory(new ValueProviderFactory());
        static::assertEquals($expectedProvider, $providerFactory->getProvider($type));
    }

    /**
     * @covers ::getProvider
     * @covers ::getPseudoStringProvider
     */
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
        yield "PseudoType ArrayKey" => [new ArrayKey(), new ValueProviderList(new StringProvider(), new IntProvider())];
        yield "PseudoType ClassString" => [new ClassString(), new ClassStringProvider()];
        yield "PseudoType ClassString Fqsen" => [
            new ClassString(new Fqsen('\\' . ValueProvider::class)),
            new ClassStringProvider('\\' . ValueProvider::class)
        ];
        yield "PseudoType CallableString" => [new CallableString(), new CallableStringProvider()];
        yield "PseudoType HtmlEscapedString" => [new HtmlEscapedString(), new HtmlEscapedStringProvider()];
        yield "PseudoType IntegerRange" => [new IntegerRange('0', '5'), new IntProvider(0, 5)];
        yield "PseudoType List" => [new List_(), new ListProvider(static::getMixedProvider())];
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

    private static function getMixedProvider(): ValueProviderList
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
