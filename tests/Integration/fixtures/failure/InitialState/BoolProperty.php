<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\failure\InitialState;

class BoolProperty
{
    /** @var bool */
    private $property;

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
