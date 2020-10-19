<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;
use Generator;
use ReflectionClass;
use ReflectionException;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPairProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver
 */
class AccessorPairProviderTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @covers ::getAccessorPairs
     * @covers ::validateAccessorPair
     * @covers       \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair
     * @covers       \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair
     * @throws ReflectionException
     */
    public function testGetAccessorPairs(DataInterface $class): void
    {
        $provider    = new AccessorPairProvider();
        $actualPairs = $provider->getAccessorPairs(new ReflectionClass($class));

        $expectedPairs = $class->getExpectedPairs();
        static::assertCount(count($expectedPairs), $actualPairs, get_class($class));
        foreach ($actualPairs as $key => $actualPair) {
            $expectedPair = $expectedPairs[$key];
            static::assertSame(get_class($class), $actualPair->getClass()->getName(), get_class($class));
            static::assertSame($expectedPair[0], $actualPair->getGetMethod()->getName(), get_class($class));
            static::assertSame($expectedPair[1], $actualPair->getSetMethod()->getName(), get_class($class));
            static::assertSame($expectedPair[2], $actualPair->hasMultiGetter(), get_class($class));
        }
    }

    /**
     * @return Generator<string, array<DataInterface>>
     * @throws ReflectionException
     */
    public function dataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data', __NAMESPACE__ . '\\data');
    }
}
