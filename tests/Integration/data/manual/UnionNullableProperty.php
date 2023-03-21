<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual;

class UnionNullableProperty
{
    private int|string|null $property;

    public function getProperty(): int|string|null
    {
        return $this->property;
    }

    public function setProperty(int|string|null $property): self
    {
        $this->property = $property;

        return $this;
    }
}
