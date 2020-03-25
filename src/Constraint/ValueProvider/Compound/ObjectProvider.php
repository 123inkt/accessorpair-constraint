<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;
use stdClass;

class ObjectProvider implements ValueProvider
{
    /**
     * @return object[]
     * @throws Exception
     */
    public function getValues(): array
    {
        $testObject        = new stdClass();
        $testObject->param = random_int(PHP_INT_MIN, PHP_INT_MAX);

        return [$testObject];
    }
}
