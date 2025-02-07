<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(ListProvider::class)]
#[UsesClass(IntProvider::class)]
class ListProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new ListProvider();
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
        static::assertValueTypes(array_merge(...$values), ['integer', 'double', 'string', 'NULL']);
        static::assertValueTypes(array_keys($values), ['integer']);
    }

    /**
     * @throws Exception
     */
    public function testGetValuesTyped(): void
    {
        $valueProvider = new ListProvider(new IntProvider());
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
        static::assertValueTypes(array_merge(...$values), ['integer']);
        static::assertValueTypes(array_keys($values), ['integer']);
    }
}
