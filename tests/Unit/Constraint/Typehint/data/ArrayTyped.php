<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;

class ArrayTyped implements DataInterface
{
    /**
     * @param int[] $param
     *
     * @return int[]
     */
    public function testMethod(array $param): array
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Array_(new Integer());
    }
}
