<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Nullable as NullableType;

class Nullable implements DataInterface
{
    /**
     * @param  ?int $param
     *
     * @return ?int
     */
    public function testMethod($param)
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new NullableType(new Integer());
    }
}
