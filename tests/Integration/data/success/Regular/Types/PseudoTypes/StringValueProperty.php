<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class StringValueProperty
{
    /** @var 'foo'|'bar'*/
    private string $property;

    /**
     * @return 'foo'|'bar'
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param 'foo'|'bar' $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
