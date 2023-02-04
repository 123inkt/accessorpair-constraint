<?php
declare(strict_types=1);

namespace Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider
 */
class HtmlEscapedStringProviderTestCase extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new HtmlEscapedStringProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['string']);
    }
}
