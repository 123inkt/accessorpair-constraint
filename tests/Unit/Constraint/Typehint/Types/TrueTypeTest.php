<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\Types;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\TrueType;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\TrueType
 */
class TrueTypeTest extends TestCase
{
    /**
     * @covers ::__toString
     */
    public function testToString(): void
    {
        static::assertSame('true', (string)new TrueType());
    }
}
