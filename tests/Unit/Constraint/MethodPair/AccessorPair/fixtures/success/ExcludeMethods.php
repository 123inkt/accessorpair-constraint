<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\success;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;
use stdClass;

class ExcludeMethods extends AbstractDataClass
{
    /** @var string|null */
    private $item;

    /** @var stdClass[] */
    private $items;

    /** @var bool */
    protected $assertParentMethod = false;

    public function setItem(string $item): void
    {
        $this->item = $item;
    }

    public function getItem(): string
    {
        return $this->item . "foobar";
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

    public function getConfig(): ConstraintConfig
    {
        return (new ConstraintConfig())->setExcludedMethods(['setItem']);
    }

    public function getExpectedPairs(): array
    {
        return [['getItems', 'setItems', false]];
    }
}
