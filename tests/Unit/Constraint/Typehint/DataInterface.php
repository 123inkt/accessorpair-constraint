<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint;

use phpDocumentor\Reflection\Type;

interface DataInterface
{
    public function getExpectedType(): Type;
}
