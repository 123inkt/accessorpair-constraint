<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class OptionalMultiProperty
{
    /** @var int[] */
    private $property;

    /**
     * @return int[]
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    public function addProperty(int $property = 123): self
    {
        $this->property[] = $property;

        return $this;
    }
}
