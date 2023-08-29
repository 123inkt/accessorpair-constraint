<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Compound;

use Countable;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IntersectionProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use stdClass;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IntersectionProvider
 */
class IntersectionProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getValues
     */
    public function testGetValues(): void
    {
        $valueProvider = new IntersectionProvider([new Object_(new Fqsen('\\' . stdClass::class)), new Object_(new Fqsen('\\' . Countable::class))]);

        static::assertContainsOnlyInstancesOf(stdClass::class, $valueProvider->getValues());
        static::assertContainsOnlyInstancesOf(Countable::class, $valueProvider->getValues());
    }
}
