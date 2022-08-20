<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;

/**
 * @template T of string
 * @template K of int
 */
class TemplateUnion implements DataInterface
{
    /**
     * @param T|K $param
     * @return T|K
     */
    public function testMethod($param)
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Compound([new String_(), new Integer()]);
    }
}
