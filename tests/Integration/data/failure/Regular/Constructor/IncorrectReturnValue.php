<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\failure\Regular\Constructor;

class IncorrectReturnValue
{
    /** @var string */
    private $property;

    public function __construct(string $property)
    {
        $this->property = $property;
    }

    public function getProperty(): string
    {
        return $this->property . '_foo';
    }
}
