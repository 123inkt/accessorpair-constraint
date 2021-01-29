<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;
use stdClass;

class ArrayAddSetGet implements DataInterface
{
    /** @var stdClass[] */
    private $items;

    /**
     * @param stdClass[] $item
     */
    public function __construct(array $item)
    {
        $this->items = $item;
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
        return [['getItems', 'item']];
    }
}
