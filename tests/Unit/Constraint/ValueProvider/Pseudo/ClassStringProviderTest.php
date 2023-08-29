<?php
declare(strict_types=1);

namespace Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider
 * @covers ::__construct
 */
class ClassStringProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     */
    public function testGetValues(): void
    {
        $valueProvider = new ClassStringProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['string']);
        foreach ($values as $value) {
            static::assertTrue(class_exists($value));
        }
    }

    /**
     * @covers ::getValues
     */
    public function testGetValuesFqsen(): void
    {
        $valueProvider = new ClassStringProvider(self::class);
        static::assertSame([self::class], $valueProvider->getValues());
    }
}
