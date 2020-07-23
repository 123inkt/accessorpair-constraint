<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider
 */
class ArrayProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::__construct
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new ArrayProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['array']);
        static::assertValueTypes(array_merge(...$values), ['integer', 'double', 'string', 'NULL']);
    }

    /**
     * @covers ::__construct
     * @covers ::getValues
     * @throws Exception
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
     */
    public function testGetValuesTyped(): void
    {
        $valueProvider = new ArrayProvider(new IntProvider());
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['array']);
        static::assertValueTypes(array_merge(...$values), ['integer']);
    }
}
