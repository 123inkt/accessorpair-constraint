<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\parentchild;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\parentchild\AbstractParentClass;

class ExcludeParentSetterChildGetter extends AbstractParentClass
{
    /** @var bool */
    protected $assertParentMethod = false;

    public function getValueA(): string
    {
        return "";
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
