<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class GetOptionalSet extends AbstractDataClass
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

    public function setProperty(string $property = null): self
    {
        $this->property = $property;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperty', 'setProperty', false]];
    }
}
