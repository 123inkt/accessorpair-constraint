<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\failure\Regular;

class UnknownType
{
    /** @var unknown */
    private $property;

    /**
     * @return unknown
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param unknown $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
