<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data\parentchild;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;

class ExcludeParentConstructorChildGetter extends AbstractParentConstructorChildGetter
{
    public function getValue(): string
    {
        return $this->value;
    }

    public function getConfig(): ConstraintConfig
    {
        return (new ConstraintConfig())->setAssertParentMethods(false);
    }

    public function getExpectedPairs(): array
    {
        return [];
    }
}
