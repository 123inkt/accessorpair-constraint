<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\String_;

class ArrayTypedFull implements DataInterface
{
    /**
     * @param array<string, string> $param
     *
     * @return array<string, string>
     */
    public function testMethod(array $param): array
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Array_(new String_(), new String_());
    }
}
