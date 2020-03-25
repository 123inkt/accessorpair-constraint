<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class NullProvider implements ValueProvider
{
    /**
     * @return null[]
     */
    public function getValues(): array
    {
        return [null];
    }
}
