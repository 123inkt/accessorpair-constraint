<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider
 */
class CallableProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::getValues
     */
    public function testGetValues()
    {
        $valueProvider = new CallableProvider();

        static::assertValueTypes($valueProvider->getValues(), ['callable']);
    }
}
