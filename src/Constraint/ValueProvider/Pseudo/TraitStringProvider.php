<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class TraitStringProvider implements ValueProvider
{
    /**
     * @return trait-string[]
     */
    public function getValues(): array
    {
        return [AccessorPairAsserter::class];
    }
}
