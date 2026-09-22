<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NonZeroIntegerProperty
{
    /** @var non-zero-int */
    private int $property;

    /**
     * @return non-zero-int
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param non-zero-int $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
