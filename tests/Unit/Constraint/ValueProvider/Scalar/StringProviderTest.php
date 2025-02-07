<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(StringProvider::class)]
class StringProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new StringProvider();

        static::assertValueTypes($valueProvider->getValues(), ['string']);
    }
}
