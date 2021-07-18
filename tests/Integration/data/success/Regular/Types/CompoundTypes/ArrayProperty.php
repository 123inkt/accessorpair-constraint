<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class ArrayProperty
{
    /** @var array */
    private $property = [];

    public function getProperty(): array
    {
        return $this->property;
    }

    public function setProperty(array $property): self
    {
        $this->property = $property;

        return $this;
    }
}
