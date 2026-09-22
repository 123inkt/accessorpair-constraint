<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class UppercaseStringProvider implements ValueProvider
{
    private StringProvider $stringProvider;

    public function __construct(StringProvider $stringProvider)
    {
        $this->stringProvider = $stringProvider;
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public function getValues(): array
    {
        return array_map('strtoupper', $this->stringProvider->getValues());
    }
}
