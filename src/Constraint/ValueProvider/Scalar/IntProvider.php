<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class IntProvider implements ValueProvider
{
    private ?int $minValue;
    private ?int $maxValue;

    public function __construct(?int $minValue = null, ?int $maxValue = null)
    {
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
    }

    /**
     * @return int[]
     * @throws Exception
     */
    public function getValues(): array
    {
        if ($this->minValue !== null && $this->maxValue !== null) {
            return [random_int($this->minValue, $this->maxValue)];
        }

        return [random_int(PHP_INT_MIN, -1), random_int(1, PHP_INT_MAX), 0];
    }
}
