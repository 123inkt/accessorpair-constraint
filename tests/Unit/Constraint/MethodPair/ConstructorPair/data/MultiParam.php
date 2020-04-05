<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

class MultiParam implements DataInterface
{
    /** @var string */
    private $property;

    /** @var string */
    private $default;

    public function __construct(string $property, string $default)
    {
        $this->property = $property;
        $this->default  = $default;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getDefault(): string
    {
        return $this->default;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperty', 'property'], ['getDefault', 'default']];
    }
}
