<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

/**
 * Get/add pair for fields ending in y (plural: - ies).
 */
class GetAddPluraly implements DataInterface
{
    /** @var string[] */
    private $properties = [];

    /**
     *
     * @return string[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    public function addProperty(string $param): self
    {
        $this->properties[] = $param;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperties', 'addProperty', true]];
    }
}
