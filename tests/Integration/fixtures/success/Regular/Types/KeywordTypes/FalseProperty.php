<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\success\Regular\Types\KeywordTypes;

class FalseProperty
{
    /** @var false */
    private $property = false;

    /**
     * @return false
     */
    public function getProperty(): bool
    {
        return $this->property;
    }

    /**
     * @param false $property
     */
    public function setProperty(bool $property): self
    {
        $this->property = $property;

        return $this;
    }
}
