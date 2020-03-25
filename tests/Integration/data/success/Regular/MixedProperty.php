<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class MixedProperty
{
    /** @var mixed */
    private $property;

    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param mixed $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
