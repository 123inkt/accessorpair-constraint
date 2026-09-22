<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Type;

class NonEmptyUppercaseStringType extends UppercaseStringType
{
    public function __toString(): string
    {
        return 'non-empty-uppercase-string';
    }
}
