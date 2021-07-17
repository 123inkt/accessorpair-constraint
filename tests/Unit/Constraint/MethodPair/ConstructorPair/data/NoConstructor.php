<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class NoConstructor extends AbstractDataClass
{
    /** @var string */
    private $property = '';

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
