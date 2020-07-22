<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Special;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider
 */
class NullProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new NullProvider();

        static::assertValueTypes($valueProvider->getValues(), ['NULL']);
    }
}
