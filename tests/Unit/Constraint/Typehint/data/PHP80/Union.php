<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\PHP80;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;

class Union implements DataInterface
{
    public function testMethod(int|string $param): int|string
    {
        return $param;
    }

    public function getExpectedType(): Compound
    {
        return new Compound([new String_(), new Integer()]);
    }
}
