<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\parentchild;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractParentClass;

class ExcludeParentGetterChildSetter extends AbstractParentClass
{
    /** @var bool */
    protected $assertParentMethod = false;

    public function setValueB(string $value): void
    {
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
