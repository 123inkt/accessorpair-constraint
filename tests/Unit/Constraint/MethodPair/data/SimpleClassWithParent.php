<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\data;

class SimpleClassWithParent extends SimpleClassWithOneMethod
{
    public function childMethod(): void
    {
    }
}
