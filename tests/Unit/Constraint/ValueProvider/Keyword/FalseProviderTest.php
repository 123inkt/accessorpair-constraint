<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Keyword;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider
 */
class FalseProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     */
    public function testGetValues(): void
    {
        $valueProvider = new FalseProvider();

        static::assertValueTypes($valueProvider->getValues(), ['false']);
    }
}
