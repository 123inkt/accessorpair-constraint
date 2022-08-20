<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Nullable as NullableType;
use phpDocumentor\Reflection\Types\String_;

/**
 * @template T of string
 */
class TemplateNullable implements DataInterface
{
    /**
     * @param T|null $param
     *
     * @return T|null
     */
    public function testMethod($param)
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new NullableType(new String_());
    }
}
