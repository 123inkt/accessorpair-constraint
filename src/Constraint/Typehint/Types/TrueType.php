<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types;

use phpDocumentor\Reflection\Type;

/**
 * Value Object representing a Boolean type.
 */
class TrueType implements Type
{
    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return 'true';
    }
}
