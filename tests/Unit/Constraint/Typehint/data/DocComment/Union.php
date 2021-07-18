<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;

class Union implements DataInterface
{
    /**
     * @param int|float $param
     *
     * @return int|float
     */
    public function testMethod($param)
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Compound([new Integer(), new Float_()]);
    }
}
