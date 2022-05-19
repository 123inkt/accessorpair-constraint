<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ConstructorPair;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Constraint\MethodPair\ClassMethodProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\TypehintResolver;
use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use LogicException;
use phpDocumentor\Reflection\Types\Array_;
use ReflectionClass;
use ReflectionParameter;

class ConstructorPairProvider
{
    private const GET_PREFIXES = ['get', 'is', 'has'];

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
     * @param ReflectionClass<object> $class
     *
     * @return ConstructorPair[]
     * @throws LogicException
     */
    public function getConstructorPairs(ReflectionClass $class): array
    {
        $parameters = $this->getParameters($class);
        if (count($parameters) === 0) {
            return [];
        }

        $pairs = [];
        foreach ((new ClassMethodProvider($this->config))->getMethods($class) as $method) {
            // Check multiple "getter" prefixes, add each getter method with corresponding setter to the inspectionMethod list
            $methodName = $method->getName();

            foreach (self::GET_PREFIXES as $getterPrefix) {
                if (strpos($methodName, $getterPrefix) !== 0) {
                    continue;
                }

                $baseMethodNames = $this->getMethodBaseNames($methodName, $getterPrefix);
                foreach ($baseMethodNames as $baseMethodName) {
                    $baseMethodName = strtolower($baseMethodName);

                    // Try and find the corresponding set/add method
                    if (isset($parameters[$baseMethodName]) === false) {
                        continue;
                    }

                    $constructorPair = new ConstructorPair($class, $method, $parameters[$baseMethodName]);
                    if ($this->validateConstructorPair($constructorPair)) {
                        $pairs[] = $constructorPair;
                    }
                }
            }
        }

        return $pairs;
    }

    /**
     * @param ReflectionClass<object> $class
     *
     * @return array<string, ReflectionParameter>
     */
    protected function getParameters(ReflectionClass $class): array
    {
        $constructor = $class->getConstructor();
        if ($constructor === null || $constructor->getNumberOfParameters() === 0) {
            return [];
        }

        // skip parent constructor
        $excludeParentMethods = $this->config->isAssertParentMethods() === false;
        if ($excludeParentMethods && $constructor->getDeclaringClass()->getName() !== $class->getName()) {
            return [];
        }

        $parameters = [];
        foreach ($constructor->getParameters() as $parameter) {
            $parameters[strtolower($parameter->getName())] = $parameter;
        }

        return $parameters;
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
