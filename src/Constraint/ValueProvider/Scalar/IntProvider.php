<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class IntProvider implements ValueProvider
{
    /**
     * @return int[]
     * @throws Exception
     */
    public function getValues(): array
    {
        return [random_int(PHP_INT_MIN, -1), random_int(1, PHP_INT_MAX), 0];
    }
}
