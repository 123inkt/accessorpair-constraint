<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CallableProvider::class)]
class CallableProviderTest extends AbstractValueProviderTestCase
{
    public function testGetValues(): void
    {
        $valueProvider = new CallableProvider();

        static::assertValueTypes($valueProvider->getValues(), ['callable']);
    }
}
