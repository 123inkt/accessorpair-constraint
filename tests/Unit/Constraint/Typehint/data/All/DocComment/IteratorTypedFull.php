<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use ArrayIterator;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\PseudoTypes\Generic;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\String_;

class IteratorTypedFull implements DataInterface
{
    /**
     * @param ArrayIterator<string, string> $param
     *
     * @return ArrayIterator<string, string>
     */
    public function testMethod(ArrayIterator $param): ArrayIterator
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Generic(new Fqsen('\\' . ArrayIterator::class), [new String_(), new String_()]);
    }
}
