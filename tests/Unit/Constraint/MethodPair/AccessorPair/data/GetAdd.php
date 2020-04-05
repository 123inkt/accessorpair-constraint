<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

class GetAdd implements DataInterface
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
