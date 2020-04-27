<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Constructor;

use stdClass;

class PropertyBag
{
    /** @var stdClass */
    private $properties;

    public function __construct()
    {
        $this->properties = new stdClass();
    }

    public function getProperty(): string
    {
        return $this->properties->property;
    }

    public function setProperty(string $property): self
    {
        $this->properties->property = $property;

        return $this;
    }
}
