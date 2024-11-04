<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\success;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class TypedArrayShapeSetGet extends AbstractDataClass
{
    /** @var array{foo: int, bar: string}[] */
    private $items;

    /**
     * @param array{foo: int, bar: string}[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param array{foo: int, bar: string} $item
     */
    public function addItem(array $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param array{foo: int, bar: string}[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return array{foo: int, bar: string}[]
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
