<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class ListProperty
{
    /** @var list */
    private array $property;

    /**
     * @return list
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    /**
     * @param list $property
     */
    public function setProperty(array $property): self
    {
        $this->property = $property;

        return $this;
    }
}
