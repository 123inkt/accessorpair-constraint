<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\Types;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\FalseType;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\FalseType
 */
class FalseTypeTest extends TestCase
{
    /**
     * @covers ::__toString
     */
    public function testToString()
    {
        static::assertSame('false', (string)new FalseType());
    }
}
