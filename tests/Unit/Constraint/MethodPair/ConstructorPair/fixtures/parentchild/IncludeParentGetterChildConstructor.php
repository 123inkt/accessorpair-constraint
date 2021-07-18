<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\fixtures\parentchild;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;

class IncludeParentGetterChildConstructor extends AbstractParentGetterChildConstructor
{
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getConfig(): ConstraintConfig
    {
        return (new ConstraintConfig())->setAssertParentMethods(true);
    }

    public function getExpectedPairs(): array
    {
        return [['getValue', 'value']];
    }
}
