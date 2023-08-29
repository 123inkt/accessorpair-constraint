<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

use ArrayIterator;
use stdClass;

class CollectionProperty
{
    /** @var ArrayIterator<stdClass> */
    private $property = false;

    /**
     * @return ArrayIterator<stdClass>
     */
    public function getProperty(): ArrayIterator
    {
        return $this->property;
    }

    /**
     * @param ArrayIterator<stdClass> $property
     */
    public function setProperty(ArrayIterator $property): self
    {
        $this->property = $property;

        return $this;
    }
}
