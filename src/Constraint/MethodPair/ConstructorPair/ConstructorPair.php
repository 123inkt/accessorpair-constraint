<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\MethodPair;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class ConstructorPair extends MethodPair
{
    /** @var ReflectionParameter */
    protected $parameter;

    public function __construct(ReflectionClass $class, ReflectionMethod $getter, ReflectionParameter $parameter)
    {
        parent::__construct($class, $getter);

        $this->parameter = $parameter;
    }

    public function getParameter(): ReflectionParameter
    {
        return $this->parameter;
    }
}
