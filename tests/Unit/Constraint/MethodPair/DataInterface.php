<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair;

interface DataInterface
{
    /**
     * @return array<int, array{0:string, 1:string, 2:bool}>
     */
    public function getExpectedPairs(): array;
}
