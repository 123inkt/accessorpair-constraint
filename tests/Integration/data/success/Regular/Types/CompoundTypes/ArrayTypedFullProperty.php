<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class ArrayTypedFullProperty
{
    /** @var array<int, string> */
    private $property = [];

    /** @var array<string, string> */
    private $propertyB = [];

    /**
     * @return array<int, string>
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    /**
     * @param array<int, string> $property
     */
    public function setProperty(array $property): self
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return  array<string, string> $propertyB
     */
    public function getPropertyB(): array
    {
        return $this->propertyB;
    }

    /**
     * @param array<string, string> $propertyB
     */
    public function setPropertyB(array $propertyB): self
    {
        $this->propertyB = $propertyB;

        return $this;
    }
}
