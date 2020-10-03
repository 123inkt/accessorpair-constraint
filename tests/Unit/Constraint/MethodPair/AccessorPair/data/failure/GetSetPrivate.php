<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

/**
 * The setter method is private, so it's not possible to select the accessormethod pair
 */
class GetSetPrivate implements DataInterface
{
    /** @var string */
    private $property = '';

    public function getProperty(): string
    {
        return $this->property;
    }

    private function setProperty(string $param): self
    {
        $this->property = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
