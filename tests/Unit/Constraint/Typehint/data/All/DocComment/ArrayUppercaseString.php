<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Type\UppercaseStringType;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Object_;

class ArrayUppercaseString implements DataInterface
{
    /**
     * @param array<uppercase-string> $param
     *
     * @return array<uppercase-string>
     */
    public function testMethod(array $param): array
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Array_(new Object_(new Fqsen('\\' . UppercaseStringType::class)));
    }
}
