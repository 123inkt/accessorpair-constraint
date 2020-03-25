<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

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

    public function getExpectedMethodPairs(): array
    {
        return [];
    }
}
