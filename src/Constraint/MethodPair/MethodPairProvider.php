<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use LogicException;
use phpDocumentor\Reflection\Types\Array_;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class MethodPairProvider
{
    const GET_PREFIXES = ['get', 'is', 'has'];
    const SET_PREFIXES = ['set', 'add'];

    /**
     * Inspect the given class, using reflection, and pair all get/set methods together
     * Loops over the public methods, and for each "getter" it tries to find the corresponding "set" and/or "add" method
     *
     * @return MethodPair[]
     * @throws ReflectionException
     * @throws LogicException
     */
    public function getMethodPairs(ReflectionClass $class): array
    {
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
                foreach (static::SET_PREFIXES as $setterPrefix) {
                    $setterName = $setterPrefix . $baseMethodName;
                    if ($class->hasMethod($setterName) === false) {
                        continue;
                    }

                    $setterMethod = $class->getMethod($setterName);
                    $methodPair   = new MethodPair($class, $method, $setterMethod);
                    if ($this->validateMethodPair($methodPair)) {
                        $pairs[] = $methodPair;
                    }
                }
            }
        }

        return $pairs;
    }

    /**
     * @throws LogicException
     */
    protected function validateMethodPair(MethodPair $methodPair): bool
    {
        $getterMethod = $methodPair->getGetMethod();
        $setterMethod = $methodPair->getSetMethod();

        // We can only test methodPairs where the getter has no parameter, and the setter has one parameter
        if ($getterMethod->getNumberOfParameters() !== 0) {
            return false;
        }
        if ($setterMethod->getNumberOfParameters() !== 1) {
            return false;
        }

        // Check if the getter's return typehint matches the setter's parameter typehint
        $parameter = $setterMethod->getParameters()[0];
        if ($methodPair->hasMultiGetter() || $parameter->isVariadic()) {
            $paramType  = (new TypehintResolver($setterMethod))->getParamTypehint($parameter);
            $returnType = (new TypehintResolver($getterMethod))->getReturnTypehint();

            return $returnType instanceof Array_ && (string)$returnType->getValueType() === (string)$paramType;
        }

        $paramType  = (new TypehintResolver($setterMethod))->getParamTypehint($parameter);
        $returnType = (new TypehintResolver($getterMethod))->getReturnTypehint();

        return (string)$paramType === (string)$returnType;
    }
}
