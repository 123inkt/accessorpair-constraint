<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class NumericStringProvider implements ValueProvider
{
    /**
     * @return numeric-string[]
     * @throws Exception
     */
    public function getValues(): array
    {
        return [(string)random_int(PHP_INT_MIN, -1), (string)random_int(1, PHP_INT_MAX), '0'];
    }
}
