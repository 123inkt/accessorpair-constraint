<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\failure\InitialState;

class ArrayProperty
{
    /** @var array */
    private $property;

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
