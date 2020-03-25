<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTest;
use Exception;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider
 * @uses \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider
 */
class FloatProviderTest extends AbstractValueProviderTest
{
    /**
     * @covers ::__construct
     * @covers ::getValues
     * @throws Exception
     */
    public function testGetValues()
    {
        $valueProvider = new FloatProvider(new IntProvider());

        static::assertValueTypes($valueProvider->getValues(), ['double']);
    }
}
