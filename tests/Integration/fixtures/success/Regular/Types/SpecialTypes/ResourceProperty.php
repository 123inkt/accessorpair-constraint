<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\success\Regular\Types\SpecialTypes;

class ResourceProperty
{
    /** @var resource */
    private $property;

    /**
     * @return resource
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param resource $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
