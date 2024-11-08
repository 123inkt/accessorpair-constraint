<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class ArrayShapeProperty
{
    /** @var array{foo: int, bar: string}[] */
    private array $items;

    /**
     * @param array{foo: int, bar: string}[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
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
}
