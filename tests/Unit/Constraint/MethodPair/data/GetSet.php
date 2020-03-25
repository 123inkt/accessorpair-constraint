<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

class GetSet implements DataInterface
{
    /** @var string */
    private $property;

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $param): self
    {
        $this->property = $param;

        return $this;
    }

    public function getExpectedMethodPairs(): array
    {
        return [['getProperty', 'setProperty', false]];
    }
}
