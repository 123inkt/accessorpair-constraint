<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class GetAddChildren extends AbstractDataClass
{
    /** @var string[] */
    private $children = [];

    /**
     *
     * @return string[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChild(string $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    public function getExpectedPairs(): array
    {
        return [['getChildren', 'addChild', true]];
    }
}
