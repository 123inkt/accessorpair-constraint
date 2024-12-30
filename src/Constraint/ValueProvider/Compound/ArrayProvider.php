<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class ArrayProvider implements ValueProvider
{
    protected ?ValueProvider $valueProvider;
    protected ?ValueProvider $keyProvider;

    public function __construct(ValueProvider $valueProvider = null, ValueProvider $keyProvider = null)
    {
        $this->valueProvider = $valueProvider;
        $this->keyProvider   = $keyProvider;
    }

    /**
     * @return array<string|int, mixed[]>
     * @inheritDoc
     */
    public function getValues(): array
    {
        $keys = [];
        if ($this->keyProvider !== null) {
            $keys = array_filter($this->keyProvider->getValues(), static fn($key): bool => $key !== '');
        }

        $testArray = [];
        $values    = $this->getArrayValues();
        foreach ($values as $i => $value) {
            $testArray[$keys[$i] ?? $i] = $value;
        }

        return [$testArray];
    }

    /**
     * @return mixed[]
     * @throws Exception
     */
    protected function getArrayValues(): array
    {
        if ($this->valueProvider !== null) {
            return $this->valueProvider->getValues();
        }

        return [1, 1.0, 'string', null];
    }
}
