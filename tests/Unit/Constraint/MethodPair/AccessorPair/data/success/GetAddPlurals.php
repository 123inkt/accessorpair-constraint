<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

class GetAddPlurals implements DataInterface
{
    /** @var string[] */
    private $values = [];

    /**
     *
     * @return string[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    public function addValue(string $param): self
    {
        $this->values[] = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [['getValues', 'addValue', true]];
    }
}
