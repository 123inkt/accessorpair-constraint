<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(ArrayProvider::class)]
#[UsesClass(IntProvider::class)]
#[UsesClass(StringProvider::class)]
class ArrayProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new ArrayProvider();
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
        static::assertValueTypes(array_merge(...$values), ['integer', 'double', 'string', 'NULL']);
        static::assertValueTypes(array_keys(...$values), ['integer']);
    }

    /**
     * @throws Exception
     */
    public function testGetValuesTyped(): void
    {
        $valueProvider = new ArrayProvider(new IntProvider(), new StringProvider());
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
        static::assertValueTypes(array_merge(...$values), ['integer']);
        static::assertValueTypes(array_keys(...$values), ['string']);
    }
}
