<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\success\Regular\Types\CompoundTypes;

class ObjectProperty
{
    /** @var object */
    private $property;

    public function getProperty(): object
    {
        return $this->property;
    }

    public function setProperty(object $property): self
    {
        $this->property = $property;

        return $this;
    }
}
