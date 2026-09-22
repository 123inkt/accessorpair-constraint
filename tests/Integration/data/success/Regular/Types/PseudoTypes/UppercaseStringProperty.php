<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class UppercaseStringProperty
{
    /** @var uppercase-string */
    private string $property;

    /**
     * @return uppercase-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param uppercase-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
