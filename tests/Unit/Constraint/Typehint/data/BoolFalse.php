<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\False_;

class BoolFalse implements DataInterface
{
    /**
     * @param false $param
     *
     * @return false
     */
    public function testMethod(bool $param): bool
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new False_();
    }
}
