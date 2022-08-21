<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\PHP81;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use Iterator;
use Countable;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Intersection as IntersectionType;
use phpDocumentor\Reflection\Types\Object_;

class Intersection implements DataInterface
{
    public function testMethod(Iterator&Countable $param): Iterator&Countable
    {
        return $param;
    }

    public function getExpectedType(): IntersectionType
    {
        return new IntersectionType(
            [
                new Object_(new Fqsen('\\' . Iterator::class)),
                new Object_(new Fqsen('\\' . Countable::class))
            ]
        );
    }
}
