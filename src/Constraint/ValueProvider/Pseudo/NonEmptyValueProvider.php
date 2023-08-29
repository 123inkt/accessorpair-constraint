<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class NonEmptyValueProvider implements ValueProvider
{
    private ValueProvider $valueProvider;

    public function __construct(ValueProvider $valueProvider)
    {
        $this->valueProvider = $valueProvider;
    }

    /**
     * @return mixed[]
     * @throws Exception
     */
    public function getValues(): array
    {
        return array_filter($this->valueProvider->getValues());
    }
}
