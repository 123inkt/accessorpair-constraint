<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\PHP80;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\String_;

class UnionNullable implements DataInterface
{
    public function testMethod(int|string|null $param): int|string|null
    {
        return $param;
    }

    public function getExpectedType(): Compound
    {
        return new Compound([new String_(), new Integer(), new Null_()]);
    }
}
