<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider
 */
class ArrayProviderTestCase extends AbstractValueProviderTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getValues
     * @covers ::getArrayValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new ArrayProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
        static::assertValueTypes(array_merge(...$values), ['integer', 'double', 'string', 'NULL']);
        static::assertValueTypes(array_keys(...$values), ['integer']);
    }

    /**
     * @covers ::__construct
     * @covers ::getValues
     * @covers ::getArrayValues
     * @throws Exception
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider
     */
    public function testGetValuesTyped(): void
    {
        $valueProvider = new ArrayProvider(new IntProvider(), new StringProvider());
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
        static::assertValueTypes(array_merge(...$values), ['integer']);
        static::assertValueTypes(array_keys(...$values), ['string']);
    }
}
