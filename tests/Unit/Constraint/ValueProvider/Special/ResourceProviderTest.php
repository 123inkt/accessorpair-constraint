<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Special;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\ResourceProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\ResourceProvider
 */
class ResourceProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues()
    {
        $valueProvider = new ResourceProvider();

        static::assertValueTypes($valueProvider->getValues(), ['resource']);
    }
}
