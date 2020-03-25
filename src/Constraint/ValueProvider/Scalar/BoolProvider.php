<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class BoolProvider implements ValueProvider
{
    /**
     * @return bool[]
     */
    public function getValues(): array
    {
        return [true, false];
    }
}
