<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\fixtures\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Nullable as NullableType;

class OptionalNull implements DataInterface
{
    /**
     * @return int|null
     */
    public function testMethod(int $param = null)
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new NullableType(new Integer());
    }
}
