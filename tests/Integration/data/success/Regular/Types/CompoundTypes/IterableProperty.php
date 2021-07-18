<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class IterableProperty
{
    /** @var iterable */
    private $property = false;

    public function getProperty(): iterable
    {
        return $this->property;
    }

    public function setProperty(iterable $property): self
    {
        $this->property = $property;

        return $this;
    }
}
