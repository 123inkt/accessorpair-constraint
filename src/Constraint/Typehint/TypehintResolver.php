<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint;

use LogicException;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;

class TypehintResolver
{
    /** @var PhpDocParser */
    protected $phpDocParser;

    /** @var ReflectionMethod */
    protected $method;

    /** @var TypeResolver */
    protected $resolver;

    /** @var Context */
    private $resolverContext;

    public function __construct(ReflectionMethod $method)
    {
        $this->phpDocParser = new PhpDocParser();
        $this->method       = $method;

        // Setup the internal type resolver
        $this->resolverContext = (new ContextFactory())->createFromReflector($method);
        $this->resolver        = new TypeResolver();
    }

    /**
     * @throws LogicException
     */
    public function getParamTypehint(ReflectionParameter $parameter): Type
    {
        // Get parameter type from method signature
        $parameterType = $parameter->getType();
        if ($parameterType instanceof ReflectionNamedType) {
            $signatureType = $parameterType->getName();
            if ($parameter->isOptional() && $parameter->allowsNull()) {
                $signatureType .= '|null';
            }
        } else {
            $signatureType = 'mixed';
        }

        // Get parameter type from phpDoc
        $docComment = $this->method->getDocComment();
        $phpDocType = $this->phpDocParser->getParamTypehint($parameter->getName(), $docComment !== false ? $docComment : '');
        if ($phpDocType === null) {
            $phpDocType = 'mixed';
        }

        return $this->resolveTypes($signatureType, $phpDocType);
    }

    /**
     * @throws LogicException
     */
    public function getReturnTypehint(): Type
    {
        // Get return type from method signature
        $returnType = $this->method->getReturnType();
        if ($returnType instanceof ReflectionNamedType) {
            $signatureType = $returnType->getName();
        } else {
            $signatureType = 'mixed';
        }

        // Get return type from phpDoc
        $docComment = $this->method->getDocComment();
        $phpDocType = $this->phpDocParser->getReturnTypehint($docComment !== false ? $docComment : '');
        if ($phpDocType === null) {
            $phpDocType = 'mixed';
        }

        return $this->resolveTypes($signatureType, $phpDocType);
    }

    protected function resolveTypes(string $signatureType, string $phpDocType): Type
    {
        // If one is mixed, return the other
        if ($phpDocType === 'mixed' && $signatureType !== 'mixed') {
            return $this->resolver->resolve($signatureType);
        }

        $phpDocType = str_replace(' ', '', $phpDocType);

        return $this->resolver->resolve($phpDocType, $this->resolverContext);
    }
}
