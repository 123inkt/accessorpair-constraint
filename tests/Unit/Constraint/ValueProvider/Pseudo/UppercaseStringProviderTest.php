<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\UppercaseStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(UppercaseStringProvider::class)]
#[UsesClass(StringProvider::class)]
#[UsesClass(NumericStringProvider::class)]
#[UsesClass(IntProvider::class)]
class UppercaseStringProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new UppercaseStringProvider(new StringProvider(new NumericStringProvider(new IntProvider())));
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['string', 'numeric-string']);
        foreach ($values as $value) {
            static::assertTrue(strtoupper($value) === $value);
        }
    }
}
