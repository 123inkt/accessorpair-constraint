<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\failure\Regular;

class IncorrectReturnValue
{
    /** @var string */
    private $property;

    public function getProperty(): string
    {
        return $this->property . '_foo';
    }

    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
