<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Type\UppercaseStringType;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\PseudoTypes\LiteralString;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Object_;

class UnionUppercaseString implements DataInterface
{
    /**
     * @param uppercase-string|literal-string $param
     *
     * @return uppercase-string|literal-string
     */
    public function testMethod(string $param): string
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Compound([new Object_(new Fqsen('\\' . UppercaseStringType::class)), new LiteralString()]);
    }
}
