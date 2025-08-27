<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class IntegerRangeMaxProperty
{
    /** @var int<10,max> */
    private int $property;

    /**
     * @return int<10,max>
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param int<10,max> $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
