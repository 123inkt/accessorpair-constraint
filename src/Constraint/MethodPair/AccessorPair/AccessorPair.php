<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AbstractMethodPair;
use ReflectionClass;
use ReflectionMethod;

class AccessorPair extends AbstractMethodPair
{
    /** @var ReflectionMethod */
    protected $setter;

    /**
     * @param ReflectionClass<object> $class
     */
    public function __construct(ReflectionClass $class, ReflectionMethod $getter, ReflectionMethod $setter)
    {
        parent::__construct($class, $getter);

        $this->setter = $setter;
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
