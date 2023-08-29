<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider
 */
class IterableProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     */
    public function testGetValues(): void
    {
        $valueProvider = new IterableProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
    }
}
