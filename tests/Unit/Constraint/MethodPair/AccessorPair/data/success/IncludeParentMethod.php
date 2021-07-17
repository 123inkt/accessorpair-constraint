<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractParentClass;
use stdClass;

class IncludeParentMethod extends AbstractParentClass
{
    /** @var bool */
    protected $assertParentMethod = true;

    /** @var stdClass[] */
    private $items;

    /**
     * @param stdClass[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return stdClass[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getExpectedPairs(): array
    {
        return [['getItems', 'setItems', false], ['getItem', 'setItem', false]];
    }
}
