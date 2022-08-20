<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

use Iterator;
use Countable;

class IntersectionProperty
{
    /** @var Iterator&Countable */
    private $property;

    /**
     * @return Iterator&Countable
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param Iterator&Countable $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
