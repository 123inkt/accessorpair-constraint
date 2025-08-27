<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\PseudoTypes\IntegerRange;
use phpDocumentor\Reflection\Type;

class IntRangeMin implements DataInterface
{
    /**
     * @param int<min, 10> $param
     *
     * @return int<min, 10>
     */
    public function testMethod(int $param): array
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new IntegerRange('min', '10');
    }
}
