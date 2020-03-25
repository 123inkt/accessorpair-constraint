<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\ScalarTypes;

class StringProperty
{
    /** @var string */
    private $property = '';

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
