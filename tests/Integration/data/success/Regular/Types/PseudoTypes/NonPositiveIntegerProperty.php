<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NonPositiveIntegerProperty
{
    /** @var non-positive-int */
    private int $property;

    /**
     * @return non-positive-int
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param non-positive-int $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
