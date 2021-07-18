<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\ScalarTypes;

class BoolProperty
{
    /** @var bool */
    private $property = false;

    public function getProperty(): bool
    {
        return $this->property;
    }

    public function setProperty(bool $property): self
    {
        $this->property = $property;

        return $this;
    }
}
