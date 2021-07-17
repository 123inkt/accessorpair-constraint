<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class NullableParam extends AbstractDataClass
{
    /** @var string|null */
    private $property;

    public function __construct(?string $property = null)
    {
        $this->property = $property;
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperty', 'property']];
    }
}
