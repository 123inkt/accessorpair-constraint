<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\parentchild;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\parentchild\AbstractParentClass;

class IncludeParentSetterChildGetter extends AbstractParentClass
{
    /** @var bool */
    protected $assertParentMethod = true;

    public function getValueA(): string
    {
        return "";
    }

    public function getExpectedPairs(): array
    {
        return [['getValueA', 'setValueA', false], ['getItem', 'setItem', false]];
    }
}
