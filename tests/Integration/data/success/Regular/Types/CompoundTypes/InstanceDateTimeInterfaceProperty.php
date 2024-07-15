<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

use DateTimeInterface;

class InstanceDateTimeInterfaceProperty
{
    /** @var DateTimeInterface */
    private $property;

    public function getProperty(): DateTimeInterface
    {
        return $this->property;
    }

    public function setProperty(DateTimeInterface $property): self
    {
        $this->property = $property;

        return $this;
    }
}
