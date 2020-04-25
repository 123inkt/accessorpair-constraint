<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

/**
 * The getter returns a different type than the setter receives
 */
class GetSet implements DataInterface
{
    private $property;

    public function getProperty(): bool
    {
        return $this->property;
    }

    public function setProperty(float $param): self
    {
        $this->property = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
