<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair;

use ReflectionClass;
use ReflectionMethod;

class MethodPair
{
    /** @var ReflectionClass */
    protected $class;

    /** @var ReflectionMethod */
    protected $getter;

    /** @var ReflectionMethod */
    protected $setter;

    public function __construct(ReflectionClass $class, ReflectionMethod $getter, ReflectionMethod $setter)
    {
        $this->class  = $class;
        $this->getter = $getter;
        $this->setter = $setter;
    }

    public function getClass(): ReflectionClass
    {
        return $this->class;
    }

    public function getGetMethod(): ReflectionMethod
    {
        return $this->getter;
    }

    public function getSetMethod(): ReflectionMethod
    {
        return $this->setter;
    }

    /**
     * Returns true if the setter is an "add" method, and the getter should return multiple values.
     * When the setter is an "add" method, the getter returns all values that were passed to the "add" method, instead of only the latest.
     */
    public function hasMultiGetter(): bool
    {
        return strpos($this->setter->getName(), 'add') === 0;
    }
}
