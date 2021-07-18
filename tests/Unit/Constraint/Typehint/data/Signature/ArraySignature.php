<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\Signature;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;

class ArraySignature implements DataInterface
{
    public function testMethod(array $param): array
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Array_();
    }
}
