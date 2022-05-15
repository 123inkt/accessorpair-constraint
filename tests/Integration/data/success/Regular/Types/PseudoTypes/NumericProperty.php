<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class NumericProperty
{
    /** @var numeric */
    private $property;

    /**
     * @return numeric
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param numeric $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
