<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair;

use ReflectionClass;
use ReflectionMethod;

abstract class AbstractMethodPair
{
    /** @var ReflectionClass<object> */
    protected $class;

    /** @var ReflectionMethod */
    protected $getter;

    /**
     * @param ReflectionClass<object> $class
     */
    public function __construct(ReflectionClass $class, ReflectionMethod $getter)
    {
        $this->class  = $class;
        $this->getter = $getter;
    }

    /**
     * @return ReflectionClass<object>
     */
    public function getClass(): ReflectionClass
    {
        return $this->class;
    }

    public function getGetMethod(): ReflectionMethod
    {
        return $this->getter;
    }
}
