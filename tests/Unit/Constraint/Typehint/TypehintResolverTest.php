<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;
use ReflectionClass;
use ReflectionException;

/**
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver
 * @covers ::__construct
 */
class TypehintResolverTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @covers ::getParamTypehint
     * @covers ::resolveTypes
     * @throws ReflectionException
     */
    public function testGetParamTypehint(DataInterface $testClass)
    {
        $reflection = new ReflectionClass($testClass);
        $method     = $reflection->getMethod('testMethod');

        $typehintResolver = new TypehintResolver($method);
        $actualReturnType = $typehintResolver->getParamTypehint($method->getParameters()[0]);

        static::assertEquals($testClass->getExpectedType(), $actualReturnType);
    }

    /**
     * @dataProvider dataProvider
     * @covers ::getReturnTypehint
     * @covers ::resolveTypes
     * @throws ReflectionException
     */
    public function testGetReturnTypehint(DataInterface $testClass)
    {
        $reflection = new ReflectionClass($testClass);
        $method     = $reflection->getMethod('testMethod');

        $typehintResolver = new TypehintResolver($method);
        $actualReturnType = $typehintResolver->getReturnTypehint();

        static::assertEquals($testClass->getExpectedType(), $actualReturnType);
    }

    /**
     * @return Generator<string, array>
     * @throws ReflectionException
     */
    public function dataProvider(): Generator
    {
        yield from $this->getClassDataProvider(__DIR__ . '/data', __NAMESPACE__ . '\data');
    }
}
