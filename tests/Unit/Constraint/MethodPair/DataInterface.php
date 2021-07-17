<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair;

interface DataInterface
{
    /**
     * Expect to return:
     * - method name of getter
     * - method name of setter
     * - true if the method has multi setter
     * @return array<int, array{0:string, 1:string, 2:bool}>
     */
    public function getExpectedPairs(): array;
}
