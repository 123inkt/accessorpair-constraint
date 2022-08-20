<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual;

class UnionProperty
{
    private int|string $property;

    public function getProperty(): int|string
    {
        return $this->property;
    }

    public function setProperty(int|string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
