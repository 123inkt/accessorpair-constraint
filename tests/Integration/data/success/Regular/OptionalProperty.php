<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class OptionalProperty
{
    /** @var int */
    private $property = 123;

    public function getProperty(): int
    {
        return $this->property;
    }

    public function setProperty(int $property = 123): self
    {
        $this->property = $property;

        return $this;
    }
}
