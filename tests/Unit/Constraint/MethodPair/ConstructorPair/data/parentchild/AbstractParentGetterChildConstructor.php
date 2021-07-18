<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data\parentchild;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

abstract class AbstractParentGetterChildConstructor extends AbstractDataClass
{
    /** @var string|null */
    protected $value;

    public function getValue(): string
    {
        return $this->value;
    }
}
