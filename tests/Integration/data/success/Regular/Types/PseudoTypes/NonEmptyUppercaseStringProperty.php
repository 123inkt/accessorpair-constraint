<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NonEmptyUppercaseStringProperty
{
    /** @var non-empty-uppercase-string */
    private string $property;

    /**
     * @return non-empty-uppercase-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param non-empty-uppercase-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
