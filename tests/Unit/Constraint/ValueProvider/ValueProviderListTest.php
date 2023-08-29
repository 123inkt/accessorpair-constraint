<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderList;
use Exception;
use LogicException;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProviderList
 */
class ValueProviderListTest extends AbstractValueProviderTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getValues
     * @throws Exception
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider
     * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
     */
    public function testGetValues(): void
    {
        $valueProvider = new ValueProviderList(new StringProvider(), new IntProvider());
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['string', 'integer']);
    }

    /**
     * @covers ::__construct
     */
    public function testGetValuesNoProviders(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("Missing valueProviders");

        new ValueProviderList();
    }

    /**
     * @covers ::__construct
     * @covers ::getValues
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
