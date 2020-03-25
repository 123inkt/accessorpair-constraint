<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class FalseProvider implements ValueProvider
{
    /**
     * @return false[]
     */
    public function getValues(): array
    {
        return [false];
    }
}
