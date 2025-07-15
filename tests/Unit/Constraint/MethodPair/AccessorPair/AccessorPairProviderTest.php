<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use ReflectionClass;
use ReflectionException;

#[CoversClass(AccessorPairProvider::class)]
#[UsesClass(TypehintResolver::class)]
#[UsesClass(PhpDocParser::class)]
#[UsesClass(ConstraintConfig::class)]
#[UsesClass(ClassMethodProvider::class)]
#[UsesClass(AbstractMethodPair::class)]
#[UsesClass(AccessorPair::class)]
class AccessorPairProviderTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testGetAccessorPairs(AbstractDataClass $class): void
    {
        $provider = new AccessorPairProvider($class->getConfig());
        $actualPairs = $provider->getAccessorPairs(new ReflectionClass($class));

        $expectedPairs = $class->getExpectedPairs();
        static::assertCount(count($expectedPairs), $actualPairs, 'Number of pairs');
        foreach ($actualPairs as $key => $actualPair) {
            $expectedPair = $expectedPairs[$key];
            static::assertSame(get_class($class), $actualPair->getClass()->getName(), 'Data class name');
            static::assertSame($expectedPair[0], $actualPair->getGetMethod()->getName(), 'Getter method');
            static::assertSame($expectedPair[1], $actualPair->getSetMethod()->getName(), 'Setter method');
            static::assertSame($expectedPair[2], $actualPair->hasMultiGetter(), 'Multi Getter');
        }
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function dataProvider(): Generator
    {
        yield from static::getClassDataProvider(__DIR__ . '/data', __NAMESPACE__ . '\\data');
    }
}
