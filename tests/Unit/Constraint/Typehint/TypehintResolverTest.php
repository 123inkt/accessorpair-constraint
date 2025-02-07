<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\PHP80\Union;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\PHP80\UnionNullable;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\PHP81\Intersection;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\UsesClass;
use ReflectionClass;
use ReflectionException;

#[CoversClass(TypehintResolver::class)]
#[UsesClass(PhpDocParser::class)]
class TypehintResolverTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    #[DataProvider('dataProvider')]
    public function testGetParamTypehintAll(DataInterface $testClass): void
    {
        static::assertParamTypehint($testClass);
    }

    /**
     * @throws ReflectionException
     */
    #[RequiresPhp('>=8.0')]
    public function testGetParamTypehintUnionType(): void
    {
        static::assertParamTypehint(new Union());
        static::assertParamTypehint(new UnionNullable());
    }

    /**
     * @throws ReflectionException
     */
    #[RequiresPhp('>=8.1')]
    public function testGetParamTypehintIntersectionType(): void
    {
        static::assertParamTypehint(new Intersection());
    }

    /**
     * @throws ReflectionException
     */
    #[DataProvider('dataProvider')]
    public function testGetReturnTypehintAll(DataInterface $testClass): void
    {
        static::assertReturnTypehint($testClass);
    }

    /**
     * @throws ReflectionException
     */
    #[RequiresPhp('>=8.0')]
    public function testGetReturnTypehintUnionType(): void
    {
        static::assertReturnTypehint(new Union());
    }

    /**
     * @throws ReflectionException
     */
    #[RequiresPhp('>=8.1')]
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
        $method = $reflection->getMethod('testMethod');

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
        $method = $reflection->getMethod('testMethod');

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
