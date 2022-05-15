<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class CallableStringProperty
{
    /** @var callable-string */
    private string $property;

    /**
     * @return callable-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param callable-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
