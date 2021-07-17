<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPairProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;
use Generator;
use ReflectionClass;
use ReflectionException;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPairProvider
 * @covers ::__construct
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver
 */
class ConstructorPairProviderTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @covers ::getConstructorPairs
     * @covers ::validateConstructorPair
     * @covers ::getParameters
     * @covers ::getMethodBaseNames
     * @covers       \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair
     * @covers       \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPair
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider
     */
    public function testGetConstructorPairs(DataInterface $class): void
    {
        $provider    = new ConstructorPairProvider(new ConstraintConfig());
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
     * @return Generator<string, array<DataInterface>>
     * @throws ReflectionException
     */
    public function dataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data', __NAMESPACE__ . '\\data');
    }
}
