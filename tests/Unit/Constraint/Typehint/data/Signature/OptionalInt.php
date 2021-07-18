<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\Signature;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Integer;

class OptionalInt implements DataInterface
{
    public function testMethod(int $param = 123): int
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Integer();
    }
}
