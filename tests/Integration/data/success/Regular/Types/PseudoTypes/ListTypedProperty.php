<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class ListTypedProperty
{
    /** @var list<int> */
    private array $property;

    /**
     * @return list<int>
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    /**
     * @param list<int> $property
     */
    public function setProperty(array $property): self
    {
        $this->property = $property;

        return $this;
    }
}
