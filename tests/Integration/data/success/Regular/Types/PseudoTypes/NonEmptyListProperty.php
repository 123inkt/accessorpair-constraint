<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NonEmptyListProperty
{
    /** @var non-empty-list */
    private array $property;

    /**
     * @return non-empty-list
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    /**
     * @param non-empty-list $property
     */
    public function setProperty(array $property): self
    {
        $this->property = $property;

        return $this;
    }
}
