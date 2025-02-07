<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FloatProvider::class)]
#[UsesClass(IntProvider::class)]
class FloatProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new FloatProvider(new IntProvider());

        static::assertValueTypes($valueProvider->getValues(), ['double']);
    }
}
