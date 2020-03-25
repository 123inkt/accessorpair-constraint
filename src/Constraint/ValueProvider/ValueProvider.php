<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;

use Exception;

interface ValueProvider
{
    /**
     * @return mixed[]
     * @throws Exception
     */
    public function getValues(): array;
}
