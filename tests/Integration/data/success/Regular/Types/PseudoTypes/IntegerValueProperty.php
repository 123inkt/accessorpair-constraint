<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class IntegerValueProperty
{
    /** @var 1|2|3 */
    private int $property;

    /**
     * @return 1|2|3
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @param 1|2|3 $property
     */
    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
