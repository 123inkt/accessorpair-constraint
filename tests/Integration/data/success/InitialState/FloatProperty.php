<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\InitialState;

class FloatProperty
{
    /** @var float */
    private $property = 0.0;

    public function getProperty(): float
    {
        return $this->property;
    }

    public function setProperty(float $property): self
    {
        $this->property = $property;

        return $this;
    }
}
