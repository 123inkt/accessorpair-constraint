<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\KeywordTypes;

class TrueProperty
{
    /** @var true */
    private $property = true;

    /**
     * @return true
     */
    public function getProperty(): bool
    {
        return $this->property;
    }

    /**
     * @param true $property
     */
    public function setProperty(bool $property): self
    {
        $this->property = $property;

        return $this;
    }
}
