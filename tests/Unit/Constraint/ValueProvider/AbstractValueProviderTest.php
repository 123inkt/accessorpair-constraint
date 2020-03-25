<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;

abstract class AbstractValueProviderTest extends TestCase
{
    abstract public function testGetValues();

    public static function assertValueTypes(array $testValues, array $expectedTypes)
    {
        static::assertNotEmpty($testValues);
        static::assertGreaterThanOrEqual(count($expectedTypes), count($testValues));

        $missingTypes = array_flip($expectedTypes);
        foreach ($testValues as $testValue) {
            $type = static::getType($testValue);
            static::assertContains($type, $expectedTypes, "Type " . $type . " is not an allowed testValue type");
            unset($missingTypes[$type]);
        }

        static::assertCount(0, $missingTypes, "Test values contain the type(s): " . implode(', ', array_flip($missingTypes)));
    }

    /**
     * @param mixed $variable
     */
    protected static function getType($variable): string
    {
        if (is_callable($variable)) {
            return "callable";
        }
        if ($variable === true) {
            return "true";
        }
        if ($variable === false) {
            return "false";
        }

        return gettype($variable);
    }
}
