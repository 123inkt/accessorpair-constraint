<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class TraitStringProperty
{
    /** @var trait-string */
    private string $property;

    /**
     * @return trait-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param trait-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
