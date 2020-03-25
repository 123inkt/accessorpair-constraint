<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
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
    public function testGetValues()
    {
        $valueProvider = new InstanceProvider(Iterator::class);
        $values        = $valueProvider->getValues();

        static::assertNotEmpty($values);
        foreach ($values as $value) {
            static::assertInstanceOf(Iterator::class, $value);
        }
    }
    /**
     * @covers ::__construct
     * @throws Exception
     */
    public function testGetValuesError()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Unknown class/interface typehint found: unknown");
        new InstanceProvider('unknown');
    }
}
