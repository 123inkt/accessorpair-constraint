<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class ObjectProperty
{
    /** @var object */
    private $property;

    /**
     * @return object
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param object $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
