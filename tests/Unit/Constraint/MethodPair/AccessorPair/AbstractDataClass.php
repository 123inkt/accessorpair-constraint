<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\DataInterface;

/**
 * @suppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractDataClass implements DataInterface
{
    /**
     * Optionally return the config used for the AccessorPairProvider test
     */
    public function getConfig(): ?ConstraintConfig
    {
        return null;
    }
}
