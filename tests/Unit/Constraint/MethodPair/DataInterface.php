<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair;

interface DataInterface
{
    public function getExpectedMethodPairs(): array;
}
