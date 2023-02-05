<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\PHP80\Union;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\PHP81\Intersection;
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
     * @covers ::getReflectionType
     * @covers ::resolveTypes
     * @covers ::resolveTemplateTypes
     * @throws ReflectionException
     */
    public function testGetParamTypehintAll(DataInterface $testClass): void
    {
        static::assertParamTypehint($testClass);
    }

    /**
     * @requires PHP >= 8.0
     * @covers ::getParamTypehint
     * @covers ::getReflectionType
     * @covers ::resolveTypes
     * @covers ::resolveTemplateTypes
     * @throws ReflectionException
     */
    public function testGetParamTypehintUnionType(): void
    {
        static::assertParamTypehint(new Union());
    }

    /**
     * @requires PHP >= 8.1
     * @covers ::getParamTypehint
     * @covers ::getReflectionType
     * @covers ::resolveTypes
     * @covers ::resolveTemplateTypes
     * @throws ReflectionException
     */
    public function testGetParamTypehintIntersectionType(): void
    {
        static::assertParamTypehint(new Intersection());
    }

    /**
     * @dataProvider dataProvider
     * @covers ::getReturnTypehint
     * @covers ::getReflectionType
     * @covers ::resolveTypes
     * @covers ::resolveTemplateTypes
     * @throws ReflectionException
     */
    public function testGetReturnTypehintAll(DataInterface $testClass): void
    {
        static::assertReturnTypehint($testClass);
    }

    /**
     * @requires PHP >= 8.0
     * @covers ::getReturnTypehint
     * @covers ::getReflectionType
     * @covers ::resolveTypes
     * @covers ::resolveTemplateTypes
     * @throws ReflectionException
     */
    public function testGetReturnTypehintUnionType(): void
    {
        static::assertReturnTypehint(new Union());
    }

    /**
     * @requires PHP >= 8.1
     * @covers ::getReturnTypehint
     * @covers ::getReflectionType
     * @covers ::resolveTypes
     * @covers ::resolveTemplateTypes
     * @throws ReflectionException
     */
    public function testGetReturnTypehintIntersectionType(): void
    {
        static::assertReturnTypehint(new Intersection());
    }

    /**
     * @throws ReflectionException
     */
    public static function assertParamTypehint(DataInterface $testClass): void
    {
        $reflection = new ReflectionClass($testClass);
        $method     = $reflection->getMethod('testMethod');

        $typehintResolver = new TypehintResolver($method);
        $actualReturnType = $typehintResolver->getParamTypehint($method->getParameters()[0]);

        static::assertEquals($testClass->getExpectedType(), $actualReturnType);
    }

    /**
     * @throws ReflectionException
     */
    public static function assertReturnTypehint(DataInterface $testClass): void
    {
        $reflection = new ReflectionClass($testClass);
        $method     = $reflection->getMethod('testMethod');

        $typehintResolver = new TypehintResolver($method);
        $actualReturnType = $typehintResolver->getReturnTypehint();

        static::assertEquals($testClass->getExpectedType(), $actualReturnType);
    }

    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function dataProvider(): Generator
    {
        yield from static::getClassDataProvider(__DIR__ . '/data/All', __NAMESPACE__ . '\data\All');
    }
}
