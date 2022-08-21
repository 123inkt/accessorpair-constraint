<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual;

use Iterator;
use Countable;

class IntersectionInterfaceProperty
{
    private Iterator&Countable $property;

    public function getProperty(): Iterator&Countable
    {
        return $this->property;
    }

    public function setProperty(Iterator&Countable $property): self
    {
        $this->property = $property;

        return $this;
    }
}
