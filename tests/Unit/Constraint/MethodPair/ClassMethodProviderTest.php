<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\data\SimpleClassWithOneMethod;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\data\SimpleClassWithParent;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider
 * @covers ::__construct
 */
class ClassMethodProviderTest extends TestCase
{
    /**
     * @covers ::getMethods
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig
     */
    public function testGetMethods(): void
    {
        $provider = new ClassMethodProvider(new ConstraintConfig());
        $methods = $provider->getMethods(new ReflectionClass(SimpleClassWithOneMethod::class));

        static::assertCount(1, $methods);
        static::assertSame('foobar', $methods[0]->getName());
    }

    /**
     * @covers ::getMethods
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig
     */
    public function testGetMethodsWithParent(): void
    {
        $provider = new ClassMethodProvider(new ConstraintConfig());
        $methods = $provider->getMethods(new ReflectionClass(SimpleClassWithParent::class));

        static::assertCount(2, $methods);
        static::assertSame('childMethod', $methods[0]->getName());
        static::assertSame('foobar', $methods[1]->getName());
    }

    /**
     * @covers ::getMethods
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig
     */
    public function testGetMethodsWithParentExcluded(): void
    {
        $provider = new ClassMethodProvider((new ConstraintConfig())->setAssertParentMethods(false));
        $methods = $provider->getMethods(new ReflectionClass(SimpleClassWithParent::class));

        static::assertCount(1, $methods);
        static::assertSame('childMethod', $methods[0]->getName());
    }

    /**
     * @covers ::getMethods
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig
     */
    public function testGetMethodsWithMethodExcluded(): void
    {
        $provider = new ClassMethodProvider((new ConstraintConfig())->setExcludedMethods(['childMethod']));
        $methods = $provider->getMethods(new ReflectionClass(SimpleClassWithParent::class));

        static::assertCount(1, $methods);
        static::assertSame('foobar', $methods[0]->getName());
    }
}
