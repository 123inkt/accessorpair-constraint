<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\AccessorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use LogicException;
use phpDocumentor\Reflection\Types\Array_;
use ReflectionClass;

class AccessorPairProvider
{
    private const GET_PREFIXES = ['get', 'is', 'has'];
    private const SET_PREFIXES = ['set', 'add'];

    /** @var Inflector */
    private $inflector;

    /** @var ConstraintConfig */
    private $config;

    public function __construct(ConstraintConfig $config)
    {
        $this->config    = $config;
        $this->inflector = InflectorFactory::create()->build();
    }

    /**
     * Inspect the given class, using reflection, and pair all get/set methods together
     * Loops over the public methods, and for each "getter" it tries to find the corresponding "set" and/or "add" method
     *
     * @return AccessorPair[]
     * @throws LogicException
     */
    public function getAccessorPairs(ReflectionClass $class): array
    {
        $pairs = [];
        foreach ((new ClassMethodProvider($this->config))->getMethods($class) as $method) {
            // Check multiple "getter" prefixes, add each getter method with corresponding setter to the inspectionMethod list
            $methodName = $method->getName();
            foreach (static::GET_PREFIXES as $getterPrefix) {
                if (strpos($methodName, $getterPrefix) !== 0) {
                    continue;
                }

                // Try and find the corresponding set/add method
                $baseMethodNames = $this->getMethodBaseNames($methodName, $getterPrefix);
                foreach ($baseMethodNames as $baseMethodName) {
                    foreach (static::SET_PREFIXES as $setterPrefix) {
                        $setterName = $setterPrefix . $baseMethodName;
                        if ($class->hasMethod($setterName) === false) {
                            continue;
                        }

                        $setterMethod = $class->getMethod($setterName);
                        if ($setterMethod->isPublic() === false || in_array($setterMethod->getName(), $this->config->getExcludedMethods(), true)) {
                            continue;
                        }

                        $accessorPair = new AccessorPair($class, $method, $setterMethod);
                        if ($this->validateAccessorPair($accessorPair)) {
                            $pairs[] = $accessorPair;
                        }
                    }
                }
            }
        }

        return $pairs;
    }

    /**
     * @return string[]
     */
    protected function getMethodBaseNames(string $methodName, string $getterPrefix): array
    {
        $baseMethodName  = substr($methodName, strlen($getterPrefix));
        $baseMethodNames = [$baseMethodName];
        $singular        = $this->inflector->singularize($baseMethodName);
        if ($singular !== $baseMethodName) {
            $baseMethodNames[] = $singular;
        }

        return $baseMethodNames;
    }

    /**
     * @throws LogicException
     */
    protected function validateAccessorPair(AccessorPair $accessorPair): bool
    {
        $getterMethod = $accessorPair->getGetMethod();
        $setterMethod = $accessorPair->getSetMethod();

        // We can only test accessorPairs where the getter has no parameter, and the setter has one parameter
        if ($getterMethod->getNumberOfParameters() !== 0) {
            return false;
        }
        if ($setterMethod->getNumberOfParameters() !== 1) {
            return false;
        }

        // Check if the getter's return typehint matches the setter's parameter typehint
        $parameter = $setterMethod->getParameters()[0];
        if ($accessorPair->hasMultiGetter() || $parameter->isVariadic()) {
            $paramType  = (string)(new TypehintResolver($setterMethod))->getParamTypehint($parameter);
            $returnType = (new TypehintResolver($getterMethod))->getReturnTypehint();

            // The getter should return an array containing the setter's input values
            if ($returnType instanceof Array_ && (string)$returnType->getValueType() === $paramType) {
                return true;
            }

            // Allow getter to return typed array or null
            return (string)$returnType === "?" . $paramType . '[]';
        }

        $paramType  = (string)(new TypehintResolver($setterMethod))->getParamTypehint($parameter);
        $returnType = (string)(new TypehintResolver($getterMethod))->getReturnTypehint();

        // Getter should return the same value, or nullable value
        return $paramType === $returnType || "?" . $paramType === $returnType;
    }
}
