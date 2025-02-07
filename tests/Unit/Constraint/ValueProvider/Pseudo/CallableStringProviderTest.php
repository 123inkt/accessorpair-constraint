<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CallableStringProvider::class)]
class CallableStringProviderTest extends AbstractValueProviderTestCase
{
    public function testGetValues(): void
    {
        $valueProvider = new CallableStringProvider();

        static::assertValueTypes($valueProvider->getValues(), ['callable']);
    }
}
