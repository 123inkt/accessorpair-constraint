<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class CallableStringProvider implements ValueProvider
{
    /**
     * @return callable-string[]
     */
    public function getValues(): array
    {
        return ['strtolower', 'array_filter'];
    }
}
