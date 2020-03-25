<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class MultiProperty
{
    /** @var string[] */
    private $property = [];

    /**
     * @return string[]
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    public function addProperty(string $property): self
    {
        $this->property[] = $property;

        return $this;
    }
}
