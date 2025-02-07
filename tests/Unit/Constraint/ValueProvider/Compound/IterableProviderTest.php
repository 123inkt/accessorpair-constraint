<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(IterableProvider::class)]
class IterableProviderTest extends AbstractValueProviderTestCase
{
    public function testGetValues(): void
    {
        $valueProvider = new IterableProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['iterable']);
    }
}
