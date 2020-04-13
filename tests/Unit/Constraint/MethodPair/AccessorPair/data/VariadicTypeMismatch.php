<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

class VariadicTypeMismatch implements DataInterface
{
    /** @var bool[] */
    private $property = [];

    /**
     * @return bool[]
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    public function setProperty(float ...$param): self
    {
        $this->property = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
