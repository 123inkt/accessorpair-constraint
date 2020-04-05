<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

class GetSetMultiParam implements DataInterface
{
    /** @var string */
    private $property;

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $param, string $default): self
    {
        $this->property = $param ?? $default;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
