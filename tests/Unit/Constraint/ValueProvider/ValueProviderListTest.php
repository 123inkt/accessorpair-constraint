<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderList;
use Exception;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(ValueProviderList::class)]
#[UsesClass(IntProvider::class)]
#[UsesClass(StringProvider::class)]
class ValueProviderListTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new ValueProviderList(new StringProvider(new NumericStringProvider(new IntProvider())), new IntProvider());
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['string', 'integer', 'numeric-string']);
    }

    public function testGetValuesNoProviders(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Missing valueProviders");

        new ValueProviderList();
    }

    /**
     * @throws Exception
     */
    public function testGetValuesEmptyProviderValues(): void
    {
        $valueProvider = new ValueProviderList(
            new class implements ValueProvider {
                public function getValues(): array
                {
                    return [];
                }
            }
        );

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("No test values retrieved for provider");
        $valueProvider->getValues();
    }
}
