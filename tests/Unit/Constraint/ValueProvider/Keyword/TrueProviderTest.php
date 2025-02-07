<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Keyword;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\TrueProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TrueProvider::class)]
class TrueProviderTest extends AbstractValueProviderTestCase
{
    public function testGetValues(): void
    {
        $valueProvider = new TrueProvider();

        static::assertValueTypes($valueProvider->getValues(), ['true']);
    }
}
