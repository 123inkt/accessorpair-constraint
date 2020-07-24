<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class NullableProperty
{
    /** @var int|null */
    private $property;

    public function getProperty(): ?int
    {
        return $this->property;
    }

    public function setProperty(?int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
