<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class IterableTypedFullProperty
{
    /** @var iterable<int, stdClass> */
    private $property = false;

    /**
     * @return iterable<int, stdClass>
     */
    public function getProperty(): iterable
    {
        return $this->property;
    }

    /**
     * @param iterable<int, stdClass> $property
     */
    public function setProperty(iterable $property): self
    {
        $this->property = $property;

        return $this;
    }
}
