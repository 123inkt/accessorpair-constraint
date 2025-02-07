<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Special;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(NullProvider::class)]
class NullProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new NullProvider();

        static::assertValueTypes($valueProvider->getValues(), ['NULL']);
    }
}
