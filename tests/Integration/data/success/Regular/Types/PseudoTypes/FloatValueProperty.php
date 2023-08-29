<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class FloatValueProperty
{
    /** @var 1.0|2.0|3.0 */
    private float $property;

    /**
     * @return 1.0|2.0|3.0
     */
    public function getProperty(): float
    {
        return $this->property;
    }

    /**
     * @param 1.0|2.0|3.0 $property
     */
    public function setProperty(float $property): self
    {
        $this->property = $property;

        return $this;
    }
}
