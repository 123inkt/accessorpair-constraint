<?php
declare(strict_types=1);

namespace Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider
 * @covers ::__construct
 */
class ListProviderTestCase extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new ListProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
        static::assertValueTypes(array_merge(...$values), ['integer', 'double', 'string', 'NULL']);
        static::assertValueTypes(array_keys($values), ['integer']);
    }

    /**
     * @covers ::__construct
     * @covers ::getValues
     * @throws Exception
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
     */
    public function testGetValuesTyped(): void
    {
        $valueProvider = new ListProvider(new IntProvider());
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
        static::assertValueTypes(array_merge(...$values), ['integer']);
        static::assertValueTypes(array_keys($values), ['integer']);
    }
}
