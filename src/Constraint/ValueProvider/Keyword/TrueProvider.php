<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class TrueProvider implements ValueProvider
{
    /**
     * @return true[]
     */
    public function getValues(): array
    {
        return [true];
    }
}
