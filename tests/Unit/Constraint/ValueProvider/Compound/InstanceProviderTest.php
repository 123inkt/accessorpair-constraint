<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DateTimeInterface;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\TestEnum;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use Iterator;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhp;

#[CoversClass(InstanceProvider::class)]
class InstanceProviderTest extends AbstractValueProviderTestCase
{
    /**
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
     * @throws Exception
     */
    #[RequiresPhp('>=8.1')]
    public function testGetEnumValues(): void
    {
        $valueProvider = new InstanceProvider(TestEnum::class);
        $values        = $valueProvider->getValues();

        static::assertNotEmpty($values);
        foreach ($values as $value) {
            static::assertInstanceOf(TestEnum::class, $value);
        }
    }

    /**
     * Test getting test cases from a DateTimeInterface
     *
     * @throws Exception
     */
    public function testGetDateTimeInterfaceValues(): void
    {
        $valueProvider = new InstanceProvider(DateTimeInterface::class);
        $values        = $valueProvider->getValues();

        static::assertNotEmpty($values);
        foreach ($values as $value) {
            static::assertInstanceOf(DateTimeInterface::class, $value);
        }
    }
}
