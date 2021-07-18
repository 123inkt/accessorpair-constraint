<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class TypeMismatch extends AbstractDataClass
{
    private $property;

    public function __construct(float $property)
    {
        $this->property = $property;
    }

    public function getProperty(): bool
    {
        return $this->property;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
