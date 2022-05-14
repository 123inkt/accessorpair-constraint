<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class LiteralStringProperty
{
    /** @var literal-string */
    private string $property;

    /**
     * @return literal-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param literal-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
