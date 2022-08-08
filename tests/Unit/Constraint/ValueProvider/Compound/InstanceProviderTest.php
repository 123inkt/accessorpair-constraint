<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\TestEnum;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;
use Exception;
use Iterator;
use LogicException;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider
 */
class InstanceProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::__construct
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new InstanceProvider(Iterator::class);
        $values        = $valueProvider->getValues();

        static::assertNotEmpty($values);
        foreach ($values as $value) {
            static::assertInstanceOf(Iterator::class, $value);
        }
    }

    /**
     * Test that the InstanceProvider returns a correct value
     * When the requested class has a constructor requirement
     * @covers ::__construct
     * @covers ::getValues
     *
     * @throws Exception
     */
    public function testGetValuesConstructorRequirements(): void
    {
        $valueProvider = new InstanceProvider(InstanceProvider::class);
        $values        = $valueProvider->getValues();

        static::assertNotEmpty($values);
        foreach ($values as $value) {
            static::assertInstanceOf(InstanceProvider::class, $value);
        }
    }

    /**
     * @covers ::__construct
     * @throws Exception
     */
    public function testGetValuesError(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Unknown class/interface typehint found: unknown");
        new InstanceProvider('unknown');
    }

    /**
     * Test getting test cases from an enum
     *
     * @covers ::__construct
     * @covers ::getValues
     * @throws Exception
     * @requires PHP >= 8.1
     */
    public function testGetEnumValues(): void
    {
        $valueProvider = new InstanceProvider(TestEnum::class);
        $values        = $valueProvider->getValues();

        static::assertNotEmpty($values);
        foreach ($values as $value) {
            static::assertInstanceOf(TestEnum::class, $value);
        }
    }
}
