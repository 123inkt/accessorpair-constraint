<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

class GetSetAddPlural implements DataInterface
{
    /** @var string[] */
    private $properties = [];

    /**
     * @return string[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param string[] $param
     */
    public function setProperties(array $param): self
    {
        $this->properties = $param;

        return $this;
    }

    public function addProperty(string $param): self
    {
        $this->properties[] = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperties', 'setProperties', false], ['getProperties', 'addProperty', true]];
    }
}
