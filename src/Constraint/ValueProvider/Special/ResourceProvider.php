<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class ResourceProvider implements ValueProvider
{
    /**
     * @return resource[]
     * @throws Exception
     */
    public function getValues(): array
    {
        return [STDOUT];
    }
}
