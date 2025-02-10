<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class NumericStringProvider implements ValueProvider
{
    public function __construct(private readonly IntProvider $intProvider)
    {
    }

    /**
     * @return numeric-string[]
     * @throws Exception
     */
    public function getValues(): array
    {
        $values = [(string)random_int(PHP_INT_MIN, -1), (string)random_int(1, PHP_INT_MAX), '0'];
        foreach ($this->intProvider->getValues() as $int) {
            $values[] = (string)$int;
        }

        return $values;
    }
}
