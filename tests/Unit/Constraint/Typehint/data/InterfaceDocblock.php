<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Object_;

class InterfaceDocblock implements DataInterface
{
    /**
     * @param ValueProvider $param
     *
     * @return ValueProvider
     */
    public function testMethod($param)
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Object_(new Fqsen('\\' . ValueProvider::class));
    }
}
