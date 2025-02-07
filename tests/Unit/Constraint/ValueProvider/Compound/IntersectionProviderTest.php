<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use Countable;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IntersectionProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use PHPUnit\Framework\Attributes\CoversClass;
use stdClass;

#[CoversClass(IntersectionProvider::class)]
class IntersectionProviderTest extends AbstractValueProviderTestCase
{
    public function testGetValues(): void
    {
        $valueProvider = new IntersectionProvider([new Object_(new Fqsen('\\' . stdClass::class)), new Object_(new Fqsen('\\' . Countable::class))]);

        static::assertContainsOnlyInstancesOf(stdClass::class, $valueProvider->getValues());
        static::assertContainsOnlyInstancesOf(Countable::class, $valueProvider->getValues());
    }
}
