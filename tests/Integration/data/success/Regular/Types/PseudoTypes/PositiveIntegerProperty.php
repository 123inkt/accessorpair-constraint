<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class PositiveIntegerProperty
{
    /** @var positive-int */
    private int $property;

    /**
     * @return positive-int
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param positive-int $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
