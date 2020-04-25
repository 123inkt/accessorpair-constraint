<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

/**
 * The setter receives multiple float values, but the getter returns an array of bool values
 */
class GetVariadicSet implements DataInterface
{
    /** @var bool[] */
    private $property = [];

    /**
     * @return bool[]
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    public function setProperty(float ...$param): self
    {
        $this->property = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
