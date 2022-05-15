<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class ArrayKeyProperty
{
    /** @var array-key */
    private $property;

    /**
     * @return array-key
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param array-key $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
