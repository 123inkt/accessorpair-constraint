<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

/**
 * The goal of the constraint is to test if the getter returns the same value as the setter received.
 * This can't be tested when the getter also has parameters.
 */
class GetParams implements DataInterface
{
    /** @var string */
    private $property;

    public function getProperty(string $default): string
    {
        return $this->property ?? $default;
    }

    public function setProperty(string $param): self
    {
        $this->property = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
