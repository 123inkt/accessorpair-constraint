<?php
declare(strict_types=1);

namespace Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayShapeProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(ArrayShapeProvider::class)]
#[UsesClass(IntProvider::class)]
#[UsesClass(StringProvider::class)]
class ArrayShapeProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @throws Exception
     */
    public function testGetValues(): void
    {
        $valueProvider = new ArrayShapeProvider(['foo' => new IntProvider(), 'bar' => new StringProvider(new NumericStringProvider(new IntProvider()))]);
        $values        = $valueProvider->getValues();

        static::assertNotCount(0, $values);
        foreach ($values as $value) {
            static::assertCount(2, $value);
            static::assertArrayHasKey('foo', $value);
            static::assertIsInt($value['foo']);
            static::assertArrayHasKey('bar', $value);
            static::assertIsString($value['bar']);
        }
    }
}
