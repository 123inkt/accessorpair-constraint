<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPairProvider;
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

#[CoversClass(ConstructorPairProvider::class)]
#[UsesClass(TypehintResolver::class)]
#[UsesClass(PhpDocParser::class)]
#[UsesClass(ConstraintConfig::class)]
#[UsesClass(ClassMethodProvider::class)]
#[CoversClass(AbstractMethodPair::class)]
#[CoversClass(ConstructorPair::class)]
class ConstructorPairProviderTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testGetConstructorPairs(AbstractDataClass $class): void
    {
        $provider = new ConstructorPairProvider($class->getConfig());
        $actualPairs = $provider->getConstructorPairs(new ReflectionClass($class));

        $expectedPairs = $class->getExpectedPairs();
        static::assertCount(count($expectedPairs), $actualPairs);
        foreach ($actualPairs as $key => $actualPair) {
            $expectedPair = $expectedPairs[$key];
            static::assertSame(get_class($class), $actualPair->getClass()->getName());
            static::assertSame($expectedPair[0], $actualPair->getGetMethod()->getName());
            static::assertSame($expectedPair[1], $actualPair->getParameter()->getName());
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
