<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\MethodPairProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;
use ReflectionClass;
use ReflectionException;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\MethodPairProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver
 */
class MethodPairProviderTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @covers ::getMethodPairs
     * @covers ::validateMethodPair
     * @covers       \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\MethodPair
     * @throws ReflectionException
     */
    public function testGetMethodPairs(DataInterface $class)
    {
        $provider    = new MethodPairProvider();
        $actualPairs = $provider->getMethodPairs(new ReflectionClass($class));

        $expectedPairs = $class->getExpectedMethodPairs();
        static::assertCount(count($expectedPairs), $actualPairs);
        foreach ($actualPairs as $key => $actualPair) {
            $expectedPair = $expectedPairs[$key];
            static::assertSame(get_class($class), $actualPair->getClass()->getName());
            static::assertSame($expectedPair[0], $actualPair->getGetMethod()->getName());
            static::assertSame($expectedPair[1], $actualPair->getSetMethod()->getName());
            static::assertSame($expectedPair[2], $actualPair->hasMultiGetter());
        }
    }

    public function dataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data', __NAMESPACE__ . '\\data');
    }
}
