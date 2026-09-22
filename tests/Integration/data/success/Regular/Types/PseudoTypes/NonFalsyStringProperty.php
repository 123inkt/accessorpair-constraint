<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NonFalsyStringProperty
{
    /** @var non-falsy-string */
    private string $property;

    /**
     * @return non-falsy-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param non-falsy-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
