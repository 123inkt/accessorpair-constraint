<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class GetParams extends AbstractDataClass
{
    /** @var string */
    private $property;

    public function __construct(string $property)
    {
        $this->property = $property;
    }

    public function getProperty(string $default): string
    {
        return $this->property ?? $default;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
