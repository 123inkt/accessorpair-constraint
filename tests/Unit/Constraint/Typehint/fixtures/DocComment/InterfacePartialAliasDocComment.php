<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\fixtures\DocComment;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Object_;

class InterfacePartialAliasDocComment implements DataInterface
{
    /**
     * @param ValueProvider\ValueProvider $param
     *
     * @return ValueProvider\ValueProvider
     */
    public function testMethod($param)
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Object_(new Fqsen('\\' . ValueProvider\ValueProvider::class));
    }
}
