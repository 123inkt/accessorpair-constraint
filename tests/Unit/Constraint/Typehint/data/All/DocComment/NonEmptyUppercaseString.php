<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\data\All\DocComment;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Type\NonEmptyUppercaseStringType;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint\DataInterface;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Object_;

class NonEmptyUppercaseString implements DataInterface
{
    /**
     * @param non-empty-uppercase-string $param
     *
     * @return non-empty-uppercase-string
     */
    public function testMethod(string $param): string
    {
        return $param;
    }

    public function getExpectedType(): Type
    {
        return new Object_(new Fqsen('\\' . NonEmptyUppercaseStringType::class));
    }
}
