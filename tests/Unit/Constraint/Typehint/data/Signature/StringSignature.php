<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\Signature;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\String_;

class StringSignature implements DataInterface
{
    public function testMethod(string $param): string
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new String_();
    }
}
