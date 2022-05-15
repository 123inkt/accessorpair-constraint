<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NegativeIntegerProperty
{
    /** @var negative-int */
    private int $property;

    /**
     * @return negative-int
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param negative-int $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
