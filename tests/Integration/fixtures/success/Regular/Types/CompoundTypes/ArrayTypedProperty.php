<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\success\Regular\Types\CompoundTypes;

class ArrayTypedProperty
{
    /** @var int[] */
    private $property = [];

    /**
     * @return int[]
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    /**
     * @param int[] $property
     */
    public function setProperty(array $property): self
    {
        $this->property = $property;

        return $this;
    }
}
