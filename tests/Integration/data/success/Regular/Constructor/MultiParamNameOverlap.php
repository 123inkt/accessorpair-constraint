<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Constructor;

class MultiParamNameOverlap
{
    /** @var string */
    private $item;

    /** @var string[] */
    private $itemList;

    /**
     * @param string[] $itemList
     */
    public function __construct(string $item, array $itemList)
    {
        $this->item = $item;
        $this->itemList = $itemList;
    }

    /**
     * @return string
     */
    public function getItem(): string
    {
        return $this->item;
    }

    /**
     * @return string[]
     */
    public function getItemList(): array
    {
        return $this->itemList;
    }
}
