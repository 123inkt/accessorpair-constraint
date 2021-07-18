<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\InitialState\Constructor;

class VariadicProperty
{
    /** @var string[] */
    private $property;

    public function __construct(string ...$property)
    {
        $this->property = $property;
    }

    /**
     * @return string[]
     */
    public function getProperty(): array
    {
        return $this->property;
    }
}
