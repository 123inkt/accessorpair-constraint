<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class CallableProperty
{
    /** @var callable */
    private $property;

    public function getProperty(): callable
    {
        return $this->property;
    }

    public function setProperty(callable $property): self
    {
        $this->property = $property;

        return $this;
    }
}
