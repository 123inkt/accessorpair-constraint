<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

class GetSetPlurals implements DataInterface
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

    /**
     * @param string[] $values
     */
    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [['getValues', 'setValues', false]];
    }
}
