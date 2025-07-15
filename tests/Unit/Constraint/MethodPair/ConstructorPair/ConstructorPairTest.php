<?php

declare(strict_types=1);

namespace Constraint\MethodPair\ConstructorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair\ConstructorPair;
use DigitalRevolution\AccessorPairConstraint\Test\AbstractDtoTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AbstractMethodPair::class)]
#[CoversClass(ConstructorPair::class)]
class ConstructorPairTest extends AbstractDtoTestCase
{
}
