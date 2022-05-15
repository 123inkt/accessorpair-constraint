<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NonEmptyStringProperty
{
    /** @var non-empty-string */
    private string $property;

    /**
     * @return non-empty-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param non-empty-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
