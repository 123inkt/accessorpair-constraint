<?php
declare(strict_types=1);

namespace Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider
 */
class LiteralStringProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new LiteralStringProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['string']);
    }
}
