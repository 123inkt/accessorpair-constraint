<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class ConstructorPair extends AbstractMethodPair
{
    /** @var ReflectionParameter */
    protected $parameter;

    /**
     * @param ReflectionClass<object> $class
     */
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
