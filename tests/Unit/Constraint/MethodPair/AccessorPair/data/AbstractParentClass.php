<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair\data;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

abstract class AbstractParentClass extends AbstractDataClass
{
    /** @var string|null */
    private $item;

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

    public function getConfig(): ConstraintConfig
    {
        return (new ConstraintConfig())->setAssertParentMethods($this->assertParentMethod);
    }
}
