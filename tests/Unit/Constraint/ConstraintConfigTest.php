<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ConstraintConfig::class)]
class ConstraintConfigTest extends TestCase
{
    public function testConfig(): void
    {
        $config = new ConstraintConfig();
        static::assertTrue($config->hasAccessorPairCheck());
        static::assertTrue($config->hasAssertConstructor());
        static::assertFalse($config->hasPropertyDefaultCheck());
        static::assertTrue($config->isAssertParentMethods());
        static::assertSame([], $config->getExcludedMethods());

        $config = new ConstraintConfig();
        static::assertFalse($config->setAssertAccessorPair(false)->hasAccessorPairCheck());
        static::assertFalse($config->setAssertConstructor(false)->hasAssertConstructor());
        static::assertFalse($config->setAssertPropertyDefaults(false)->hasPropertyDefaultCheck());
        static::assertFalse($config->setAssertParentMethods(false)->isAssertParentMethods());
        static::assertSame(['foobar'], $config->setExcludedMethods(['foobar'])->getExcludedMethods());

        $config = new ConstraintConfig();
        static::assertTrue($config->setAssertAccessorPair(true)->hasAccessorPairCheck());
        static::assertTrue($config->setAssertConstructor(true)->hasAssertConstructor());
        static::assertTrue($config->setAssertPropertyDefaults(true)->hasPropertyDefaultCheck());
        static::assertTrue($config->setAssertParentMethods(true)->isAssertParentMethods());

        $config = new ConstraintConfig();
        $callback = static function (): array {
            return [];
        };
        static::assertNull($config->getConstructorCallback());
        static::assertSame($callback, $config->setConstructorCallback($callback)->getConstructorCallback());

        $config = new ConstraintConfig();
        $valueProvider = static function (): ?object {
            return null;
        };

        static::assertNull($config->getValueProvider());
        static::assertSame($valueProvider, $config->setValueProvider($valueProvider)->getValueProvider());
    }
}
