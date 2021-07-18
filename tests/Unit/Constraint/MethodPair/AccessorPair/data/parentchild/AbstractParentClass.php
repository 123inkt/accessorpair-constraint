<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data\parentchild;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

abstract class AbstractParentClass extends AbstractDataClass
{
    /** @var bool */
    protected $assertParentMethod = true;

    /** @var string|null */
    private $value;

    public function setValueA(string $valueA): void
    {
        $this->value = $valueA;
    }

    public function getValueB(): string
    {
        return "";
    }

    public function setItem(string $item): void
    {
        $this->value = $item;
    }

    public function getItem(): string
    {
        return "";
    }

    public function getConfig(): ConstraintConfig
    {
        return (new ConstraintConfig())->setAssertParentMethods($this->assertParentMethod);
    }
}
