<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;

/**
 * @suppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractDataClass
{
    /**
     * Return the config used for the AccessorPairProvider test
     */
    public function getConfig(): ConstraintConfig
    {
        return new ConstraintConfig();
    }

    /**
     * Expect to return:
     * - method name of getter
     * - method name of setter
     * - true if the method has multi setter
     * @return array<int, array{0:string, 1:string, 2:bool}>
     */
    abstract public function getExpectedPairs(): array;
}
