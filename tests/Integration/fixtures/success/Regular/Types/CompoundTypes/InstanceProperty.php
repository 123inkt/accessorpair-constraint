<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\success\Regular\Types\CompoundTypes;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class InstanceProperty
{
    /** @var ValueProvider */
    private $property;

    public function getProperty(): ValueProvider
    {
        return $this->property;
    }

    public function setProperty(ValueProvider $property): self
    {
        $this->property = $property;

        return $this;
    }
}
