<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ObjectProvider::class)]
class ObjectProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new ObjectProvider();
        $values        = $valueProvider->getValues();

        static::assertValueTypes($values, ['object']);
    }
}
