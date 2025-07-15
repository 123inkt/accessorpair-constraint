<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AccessorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair\AccessorPair;
use DigitalRevolution\AccessorPairConstraint\Test\AbstractDtoTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AbstractMethodPair::class)]
#[CoversClass(AccessorPair::class)]
class AccessorPairTest extends AbstractDtoTestCase
{
}
