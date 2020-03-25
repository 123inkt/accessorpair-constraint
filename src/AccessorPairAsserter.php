<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint;

use DigitalRevolution\AccessorPairConstraint\Constraint\AccessorPairConstraint;
use PHPUnit\Framework\Assert;

trait AccessorPairAsserter
{
    /**
     * @param string $object               The fully qualified name of the class that should be tested
     * @param bool   $testPropertyDefaults When true, the getter methods are called on an empty instance of the test object.
     *                                     This makes sure that all the properties have the correct default type,
     *                                     conforming the getter return typehint.
     * @param string $message              Customer PHPUnit error message in case of constraint failure
     */
    public static function assertAccessorPairs(string $object, bool $testPropertyDefaults = false, string $message = '')
    {
        Assert::assertThat($object, new AccessorPairConstraint($testPropertyDefaults), $message);
    }
}
