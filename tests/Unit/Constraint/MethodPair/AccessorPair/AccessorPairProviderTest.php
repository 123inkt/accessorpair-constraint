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
 * @covers ::__construct
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver
 */
class AccessorPairProviderTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @covers ::getAccessorPairs
     * @covers ::getClassMethods
     * @covers ::validateAccessorPair
     * @covers ::getMethodBaseNames
     * @covers       \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair
     * @covers       \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair
     * @throws ReflectionException
     */
    public function testGetAccessorPairs(AbstractDataClass $class): void
    {
        $provider    = new AccessorPairProvider($class->getConfig());
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
     * @return Generator<string, array<DataInterface>>
     * @throws ReflectionException
     */
    public function dataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data', __NAMESPACE__ . '\\data');
    }
}
