<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class IntegerRangeProperty
{
    /** @var int<10,15> */
    private int $property;

    /**
     * @return int<10,15>
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param int<10,15> $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
