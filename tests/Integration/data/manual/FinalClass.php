<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual;

final class FinalClass
{
    private int $intValue;
    private FinalClass $property;

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
}
