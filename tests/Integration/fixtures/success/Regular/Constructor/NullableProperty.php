<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\success\Regular\Constructor;

class NullableProperty
{
    /** @var int|null */
    private $property;

    public function __construct(?int $property = null)
    {
        $this->property = $property;
    }

    public function getProperty(): ?int
    {
        return $this->property;
    }
}
