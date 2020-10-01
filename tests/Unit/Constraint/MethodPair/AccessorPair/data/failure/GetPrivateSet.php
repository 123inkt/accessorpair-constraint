<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

/**
 * The getter method is private, so it's not possible to select the accessormethod pair
 * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
 */
class GetPrivateSet implements DataInterface
{
    /** @var string */
    private $property = '';

    private function getProperty(): string
    {
        return $this->property;
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
