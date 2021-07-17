<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;

abstract class AbstractParentClass extends AbstractDataClass
{
    /** @var string|null */
    private $item;

    /** @var bool */
    protected $assertParentMethod = true;

    public function __construct(string $item = "")
    {
        $this->item = $item;
    }

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
