<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class UnionProperty
{
    /** @var int|string */
    private $property;

    /**
     * @return int|string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param int|string $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
