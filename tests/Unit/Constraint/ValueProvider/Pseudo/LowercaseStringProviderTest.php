<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LowercaseStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(LowercaseStringProvider::class)]
#[UsesClass(StringProvider::class)]
class LowercaseStringProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new LowercaseStringProvider(new StringProvider(new NumericStringProvider(new IntProvider())));
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['string', 'numeric-string']);
        foreach ($values as $value) {
            static::assertTrue(strtolower($value) === $value);
        }
    }
}
