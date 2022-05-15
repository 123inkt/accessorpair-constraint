<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NumericStringProperty
{
    /** @var numeric-string */
    private string $property;

    /**
     * @return numeric-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param numeric-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
