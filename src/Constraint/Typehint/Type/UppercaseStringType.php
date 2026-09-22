<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Type;

use phpDocumentor\Reflection\Type;

class UppercaseStringType implements Type
{
    public function __toString(): string
    {
        return 'uppercase-string';
    }
}
