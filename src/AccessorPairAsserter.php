<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint;

use DigitalRevolution\AccessorPairConstraint\Constraint\AccessorPairConstraint;
use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use PHPUnit\Framework\Assert;

trait AccessorPairAsserter
{
    /**
     * @param string           $object  The fully qualified name of the class that should be tested
     * @param ConstraintConfig $config  Configuration of the constraint.
     *                                  By default the getter/setter pairs and constructor/getter pairs will be tested
     * @param string           $message Custom PHPUnit error message in case of constraint failure
     */
    public static function assertAccessorPairs(string $object, ConstraintConfig $config = null, string $message = '')
    {
        if ($config === null) {
            $config = new ConstraintConfig();
        }

        Assert::assertThat($object, new AccessorPairConstraint($config), $message);
    }
}
