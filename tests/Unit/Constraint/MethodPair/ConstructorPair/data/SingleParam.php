<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class SingleParam extends AbstractDataClass
{
    /** @var string */
    private $property;

    public function __construct(string $property)
    {
        $this->property = $property;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperty', 'property']];
    }
}
