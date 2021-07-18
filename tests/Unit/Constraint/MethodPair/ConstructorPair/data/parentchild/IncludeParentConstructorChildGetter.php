<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data\parentchild;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;

class IncludeParentConstructorChildGetter extends AbstractParentConstructorChildGetter
{
    public function getValue(): string
    {
        return $this->value;
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
