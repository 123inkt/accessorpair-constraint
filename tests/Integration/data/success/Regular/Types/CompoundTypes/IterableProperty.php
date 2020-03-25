<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class IterableProperty
{
    /** @var iterable */
    private $property = false;

    /**
     * @return iterable
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param iterable $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
