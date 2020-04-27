<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use LogicException;
use phpDocumentor\Reflection\Types\Array_;
use ReflectionClass;
use ReflectionMethod;

class ConstructorPairProvider
{
    const GET_PREFIXES = ['get', 'is', 'has'];

    /**
     * @return ConstructorPair[]
     * @throws LogicException
     */
    public function getConstructorPairs(ReflectionClass $class): array
    {
        $constructor = $class->getConstructor();
        if ($constructor === null || $constructor->getNumberOfParameters() === 0) {
            return [];
        }

        $parameters = [];
        foreach ($constructor->getParameters() as $parameter) {
            $parameters[strtolower($parameter->getName())] = $parameter;
        }

        $pairs = [];
        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            // Check multiple "getter" prefixes, add each getter method with corresponding setter to the inspectionMethod list
            $methodName = $method->getName();
            foreach (static::GET_PREFIXES as $getterPrefix) {
                if (strpos($methodName, $getterPrefix) !== 0) {
                    continue;
                }

                // Try and find the corresponding set/add method
                $baseMethodName = substr($methodName, strlen($getterPrefix));
                if (isset($parameters[strtolower($baseMethodName)]) === false) {
                    continue;
                }

                $constructorPair = new ConstructorPair($class, $method, $parameters[strtolower($baseMethodName)]);
                if ($this->validateConstructorPair($constructorPair)) {
                    $pairs[] = $constructorPair;
                }
            }
        }

        return $pairs;
    }

    /**
     * @throws LogicException
     */
    protected function validateConstructorPair(ConstructorPair $constructorPair): bool
    {
        $getterMethod = $constructorPair->getGetMethod();
        $setterMethod = $constructorPair->getClass()->getConstructor();

        // The class should have a constructor, and we can only test accessorPairs where the getter has no parameter, and the setter has one parameter
        if ($setterMethod === null || $getterMethod->getNumberOfParameters() !== 0) {
            return false;
        }

        // Check if the getter's return typehint matches the setter's parameter typehint
        $parameter = $constructorPair->getParameter();
        if ($parameter->isVariadic()) {
            $paramType  = (new TypehintResolver($setterMethod))->getParamTypehint($parameter);
            $returnType = (new TypehintResolver($getterMethod))->getReturnTypehint();

            return $returnType instanceof Array_ && (string)$returnType->getValueType() === (string)$paramType;
        }

        $paramType  = (new TypehintResolver($setterMethod))->getParamTypehint($parameter);
        $returnType = (new TypehintResolver($getterMethod))->getReturnTypehint();

        return (string)$paramType === (string)$returnType;
    }
}
