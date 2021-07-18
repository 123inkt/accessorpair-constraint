<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

/**
 * The setter receives multiple float values, but the getter returns an array of bool values
 */
class GetVariadicSet extends AbstractDataClass
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
