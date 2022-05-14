<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NonEmptyLowercaseStringProperty
{
    /** @var non-empty-lowercase-string */
    private string $property;

    /**
     * @return non-empty-lowercase-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param non-empty-lowercase-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
