<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class GetAddPlurals extends AbstractDataClass
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
