<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\parentchild;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\fixtures\parentchild\AbstractParentClass;

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
