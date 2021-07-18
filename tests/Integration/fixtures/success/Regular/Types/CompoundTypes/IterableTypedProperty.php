<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\success\Regular\Types\CompoundTypes;

class IterableTypedProperty
{
    /** @var iterable<stdClass> */
    private $property = false;

    /**
     * @return iterable<stdClass>
     */
    public function getProperty(): iterable
    {
        return $this->property;
    }

    /**
     * @param iterable<stdClass> $property
     */
    public function setProperty(iterable $property): self
    {
        $this->property = $property;

        return $this;
    }
}
