<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual;

final class FinalClass
{
    private int $intValue;
    private FinalClass $property;
    private ?FinalClass $nullableProperty = null;
    private FinalClass|null $nullUnionProperty = null;

    public function getIntValue(): int
    {
        return $this->intValue;
    }

    public function setIntValue(int $intValue): void
    {
        $this->intValue = $intValue;
    }

    public function getProperty(): FinalClass
    {
        return $this->property;
    }

    public function setProperty(FinalClass $property): void
    {
        $this->property = $property;
    }

    public function getNullableProperty(): ?FinalClass
    {
        return $this->nullableProperty;
    }

    public function setNullableProperty(?FinalClass $nullableProperty): void
    {
        $this->nullableProperty = $nullableProperty;
    }

    public function getNullUnionProperty(): FinalClass|null
    {
        return $this->nullUnionProperty;
    }

    public function setNullUnionProperty(FinalClass|null $nullUnionProperty): void
    {
        $this->nullUnionProperty = $nullUnionProperty;
    }
}
