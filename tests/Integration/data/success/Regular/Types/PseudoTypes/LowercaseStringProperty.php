<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class LowercaseStringProperty
{
    /** @var lowercase-string */
    private string $property;

    /**
     * @return lowercase-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param lowercase-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
