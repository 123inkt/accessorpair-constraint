<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\SpecialTypes;

class NullProperty
{
    /** @var null */
    private $property;

    /**
     * @return null
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param null $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
