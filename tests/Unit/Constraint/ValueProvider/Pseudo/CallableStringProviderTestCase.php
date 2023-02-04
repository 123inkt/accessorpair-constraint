<?php
declare(strict_types=1);

namespace Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider
 */
class CallableStringProviderTestCase extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     */
    public function testGetValues(): void
    {
        $valueProvider = new CallableStringProvider();

        static::assertValueTypes($valueProvider->getValues(), ['callable']);
    }
}
