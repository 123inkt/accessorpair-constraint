<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\success\Regular\Constructor;

use stdClass;

class ArrayAddProperty
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
}
