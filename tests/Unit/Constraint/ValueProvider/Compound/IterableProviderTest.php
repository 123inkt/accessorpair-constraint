<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;
use Traversable;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider
 */
class IterableProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::getValues
     */
    public function testGetValues()
    {
        $valueProvider = new IterableProvider();
        $values        = $valueProvider->getValues();

        static::assertNotEmpty($values);
        foreach ($values as $value) {
            static::assertTrue(is_array($value) || $value instanceof Traversable);
        }
    }
}
