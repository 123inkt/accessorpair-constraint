<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair;

use ReflectionClass;
use ReflectionMethod;

abstract class AbstractMethodPair
{
    /** @var ReflectionClass */
    protected $class;

    /** @var ReflectionMethod */
    protected $getter;

    public function __construct(ReflectionClass $class, ReflectionMethod $getter)
    {
        $this->class  = $class;
        $this->getter = $getter;
    }

    public function getClass(): ReflectionClass
    {
        return $this->class;
    }

    public function getGetMethod(): ReflectionMethod
    {
        return $this->getter;
    }
}
