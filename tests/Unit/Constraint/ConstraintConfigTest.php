<?php
declare(strict_types=1);

namespace Constraint;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig
 */
class ConstraintConfigTest extends TestCase
{
    /**
     * @covers ::setAccessorPairCheck
     * @covers ::hasAccessorPairCheck
     * @covers ::setConstructorPairCheck
     * @covers ::hasConstructorPairCheck
     * @covers ::setPropertyDefaultCheck
     * @covers ::hasPropertyDefaultCheck
     */
    public function testConfig()
    {
        $config = new ConstraintConfig();
        static::assertTrue($config->hasAccessorPairCheck());
        static::assertTrue($config->hasConstructorPairCheck());
        static::assertFalse($config->hasPropertyDefaultCheck());

        $config = new ConstraintConfig();
        static::assertFalse($config->setAccessorPairCheck(false)->hasAccessorPairCheck());
        static::assertFalse($config->setConstructorPairCheck(false)->hasConstructorPairCheck());
        static::assertFalse($config->setPropertyDefaultCheck(false)->hasPropertyDefaultCheck());

        $config = new ConstraintConfig();
        static::assertTrue($config->setAccessorPairCheck(true)->hasAccessorPairCheck());
        static::assertTrue($config->setConstructorPairCheck(true)->hasConstructorPairCheck());
        static::assertTrue($config->setPropertyDefaultCheck(true)->hasPropertyDefaultCheck());
    }
}
