<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint;

use DigitalRevolution\AccessorPairConstraint\Constraint\AccessorPairConstraint;
use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use PHPUnit\Framework\Assert;

trait AccessorPairAsserter
{
    /**
     * Assert the constructor parameter - method pairs. Will use default configuration
     * with ConstraintConfig::setAssertPropertyDefaults(true)
     *
     * @param string $object  The fully qualified name of the class that should be tested
     * @param string $message Custom PHPUnit error message in case of constraint failure
     */
    public static function assertAccessorPropertyDefaults(string $object, string $message = ''): void
    {
        $config = (new ConstraintConfig())->setAssertPropertyDefaults(true);
        Assert::assertThat($object, new AccessorPairConstraint($config), $message);
    }

    /**
     * @param string                $object  The fully qualified name of the class that should be tested
     * @param ConstraintConfig|null $config  Configuration of the constraint.
     *                                       By default the getter/setter pairs and constructor/getter pairs will be tested
     * @param string                $message Custom PHPUnit error message in case of constraint failure
     */
    public static function assertAccessorPairs(string $object, ?ConstraintConfig $config = null, string $message = ''): void
    {
        if ($config === null) {
            $config = new ConstraintConfig();
        }

        Assert::assertThat($object, new AccessorPairConstraint($config), $message);
    }

    /**
     * Only assert accessor pairs from the class itself and none of its parents. Will use default configuration
     * with ConstraintConfig::setAssertParentMethods(false)
     *
     * @param string $object  The fully qualified name of the class that should be tested
     * @param string $message Custom PHPUnit error message in case of constraint failure
     */
    public static function assertOwnAccessorPairs(string $object, string $message = ''): void
    {
        $config = (new ConstraintConfig())->setAssertParentMethods(false);
        Assert::assertThat($object, new AccessorPairConstraint($config), $message);
    }
}
