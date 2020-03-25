<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider
 */
class BoolProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::getValues
     */
    public function testGetValues()
    {
        $valueProvider = new BoolProvider();

        static::assertValueTypes($valueProvider->getValues(), ['true', 'false']);
    }
}
