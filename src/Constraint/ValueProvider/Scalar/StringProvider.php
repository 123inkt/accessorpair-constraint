<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class StringProvider implements ValueProvider
{
    /**
     * @return string[]
     * @throws Exception
     */
    public function getValues(): array
    {
        return [bin2hex(random_bytes(8)), bin2hex(random_bytes(16)), '✓'];
    }
}
