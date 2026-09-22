<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NonNegativeIntegerProperty
{
    /** @var non-negative-int */
    private int $property;

    /**
     * @return non-negative-int
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param non-negative-int $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
