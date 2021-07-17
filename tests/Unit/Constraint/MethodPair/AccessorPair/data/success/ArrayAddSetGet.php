<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;
use stdClass;

class ArrayAddSetGet extends AbstractDataClass
{
    /** @var stdClass[] */
    private $items;

    /**
     * @param stdClass[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function addItem(stdClass $item): void
    {
        $this->items[] = $item;
    }

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
        return [['getItems', 'setItems', false], ['getItems', 'addItem', true]];
    }
}
