<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

/**
 * The add method receives a string, so we expect "string[]" back from getProperty.
 * The generic "array" return type there is not accepted and should be expanded using docblock.
 */
class GetAdd implements DataInterface
{
    /** @var string[] */
    private $property = [];

    public function getProperty(): array
    {
        return $this->property;
    }

    public function addProperty(string $param): self
    {
        $this->property[] = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
