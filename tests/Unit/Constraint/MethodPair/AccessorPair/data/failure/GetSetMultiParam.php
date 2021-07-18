<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\failure;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

/**
 * The setter has multiple parameters
 * The constraint can't test that the received input will be correctly returned by the getter here
 */
class GetSetMultiParam extends AbstractDataClass
{
    /** @var string */
    private $property;

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $param, string $default): self
    {
        $this->property = $param ?? $default;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
