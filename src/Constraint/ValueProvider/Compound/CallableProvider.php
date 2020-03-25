<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class CallableProvider implements ValueProvider
{
    /**
     * @return callable[]
     */
    public function getValues(): array
    {
        return [[$this, 'getValues']];
    }
}
