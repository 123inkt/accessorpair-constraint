<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class StringProvider implements ValueProvider
{
    public function __construct(private readonly NumericStringProvider $numericStringProvider)
    {
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public function getValues(): array
    {
        $values = [
            bin2hex(random_bytes(8)),
            bin2hex(random_bytes(16)),
            strtoupper(bin2hex(random_bytes(8))),
            strtoupper(bin2hex(random_bytes(16))),
            '✓',
            ''
        ];

        return array_merge($values, $this->numericStringProvider->getValues());
    }
}
