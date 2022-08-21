<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\True_;

class BoolTrue implements DataInterface
{
    /**
     * @param true $param
     *
     * @return true
     */
    public function testMethod(bool $param): bool
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new True_();
    }
}
