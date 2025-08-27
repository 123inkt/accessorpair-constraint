<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class IntegerRangeMinProperty
{
    /** @var int<min,10> */
    private int $property;

    /**
     * @return int<min,10>
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param int<min,10> $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
