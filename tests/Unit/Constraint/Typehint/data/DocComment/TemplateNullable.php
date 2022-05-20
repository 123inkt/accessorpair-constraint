<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\String_;
use phpDocumentor\Reflection\Types\Nullable as NullableType;

/**
 * @template T of string
 */
class TemplateNullable implements DataInterface
{
    /**
     * @phpstan-param T|null $param
     *
     * @phpstan-return T|null
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
