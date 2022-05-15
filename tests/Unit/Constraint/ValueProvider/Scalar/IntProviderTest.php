<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
 * @covers ::__construct
 */
class IntProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new IntProvider();

        static::assertValueTypes($valueProvider->getValues(), ['integer']);
    }

    /**
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValuesRange(): void
    {
        $valueProvider = new IntProvider(0, 5);
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['integer']);
        foreach ($values as $value) {
            static::assertGreaterThanOrEqual(0, $value);
            static::assertLessThanOrEqual(5, $value);
        }
    }
}
