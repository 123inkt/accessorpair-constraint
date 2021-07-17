<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\AbstractDataClass;

class GetAdd extends AbstractDataClass
{
    /** @var string[] */
    private $property = [];

    /**
     * @return string[]
     */
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
        return [['getProperty', 'addProperty', true]];
    }
}
