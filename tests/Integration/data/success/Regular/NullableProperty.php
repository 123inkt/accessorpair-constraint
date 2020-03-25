<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class NullableProperty
{
    /** @var ?int */
    private $property;

    /**
     * @return ?int
     */
    public function getProperty()
    {
        return $this->property;
    }

    public function setProperty(int $property = null): self
    {
        $this->property = $property;

        return $this;
    }
}
