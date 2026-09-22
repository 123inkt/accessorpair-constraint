<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Type\UppercaseStringType;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;

class UppercaseString implements DataInterface
{
    /**
     * @param uppercase-string $param
     *
     * @return uppercase-string
     */
    public function testMethod(string $param): string
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new UppercaseStringType();
    }
}
