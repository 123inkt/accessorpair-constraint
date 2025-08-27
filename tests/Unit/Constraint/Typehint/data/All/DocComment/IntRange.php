<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\PseudoTypes\IntegerRange;
use phpDocumentor\Reflection\Type;

class IntRange implements DataInterface
{
    /**
     * @param int<1, 10> $param
     *
     * @return int<1, 10>
     */
    public function testMethod(int $param): array
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new IntegerRange('1', '10');
    }
}
