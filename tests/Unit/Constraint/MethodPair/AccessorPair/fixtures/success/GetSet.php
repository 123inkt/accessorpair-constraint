<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class GetSet extends AbstractDataClass
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

    public function getExpectedPairs(): array
    {
        return [['getProperty', 'setProperty', false]];
    }
}
