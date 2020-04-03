<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Null_;

class Optional implements DataInterface
{
    /**
     * @param int|null $param
     *
     * @return int|null
     */
    public function testMethod(int $param = null)
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Compound([new Integer(), new Null_()]);
    }
}
