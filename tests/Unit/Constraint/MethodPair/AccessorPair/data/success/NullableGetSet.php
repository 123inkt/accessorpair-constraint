<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class NullableGetSet extends AbstractDataClass
{
    /** @var string|null */
    private $property;

    /**
     * @return string|null
     */
    public function getProperty()
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
