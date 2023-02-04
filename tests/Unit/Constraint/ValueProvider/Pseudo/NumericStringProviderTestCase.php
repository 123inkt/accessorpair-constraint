<?php
declare(strict_types=1);

namespace Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider
 */
class NumericStringProviderTestCase extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new NumericStringProvider();
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['string']);
        static::assertContainsOnly('numeric', $values);
    }
}
