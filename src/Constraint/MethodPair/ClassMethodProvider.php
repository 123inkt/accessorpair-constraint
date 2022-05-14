<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use ReflectionClass;
use ReflectionMethod;

class ClassMethodProvider
{
    /** @var ConstraintConfig */
    private $config;

    public function __construct(ConstraintConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param ReflectionClass<object> $class
     *
     * @return ReflectionMethod[]
     */
    public function getMethods(ReflectionClass $class): array
    {
        $excludeParentMethods = $this->config->isAssertParentMethods() === false;
        $excludedMethods      = $this->config->getExcludedMethods();

        $methods = [];
        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            // exclude all methods that are not from the class' parent class.
            if ($excludeParentMethods && $class->getName() !== $method->getDeclaringClass()->getName()) {
                continue;
            }

            // method is specifically excluded
            if (in_array($method->getName(), $excludedMethods, true)) {
                continue;
            }

            $methods[] = $method;
        }

        return $methods;
    }
}
