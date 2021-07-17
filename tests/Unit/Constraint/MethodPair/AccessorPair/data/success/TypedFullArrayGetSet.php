<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\AbstractDataClass;

class TypedFullArrayGetSet extends AbstractDataClass
{
    /** @var array<int, string> */
    private $property = [];

    /**
     * @return array<int, string>
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param array<int, string> $param
     */
    public function setProperty(array $param): self
    {
        $this->property = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperty', 'setProperty', false]];
    }
}
