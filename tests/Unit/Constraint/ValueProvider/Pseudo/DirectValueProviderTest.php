<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\DirectValueProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use phpDocumentor\Reflection\PseudoTypes\StringValue;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(DirectValueProvider::class)]
class DirectValueProviderTest extends AbstractValueProviderTestCase
{
    public function testGetValues(): void
    {
        $provider = new DirectValueProvider(new StringValue('value'));
        static::assertSame(['value'], $provider->getValues());
    }
}
