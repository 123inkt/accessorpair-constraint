<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ClassStringProvider::class)]
class ClassStringProviderTest extends AbstractValueProviderTestCase
{
    public function testGetValues(): void
    {
        $valueProvider = new ClassStringProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['string']);
        foreach ($values as $value) {
            static::assertTrue(class_exists($value));
        }
    }

    public function testGetValuesFqsen(): void
    {
        $valueProvider = new ClassStringProvider(self::class);
        static::assertSame([self::class], $valueProvider->getValues());
    }
}
