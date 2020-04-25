<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\FalseType;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\TrueType;
use LogicException;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionMethod;
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
        $this->resolver->addKeyword('true', TrueType::class);
        $this->resolver->addKeyword('false', FalseType::class);
    }

    /**
     * @throws LogicException
     */
    public function getParamTypehint(ReflectionParameter $parameter): Type
    {
        // Get parameter type from method signature
        if ($parameter->getType()) {
            $signatureType = (string)$parameter->getType();
            if ($parameter->isOptional() && $parameter->allowsNull()) {
                $signatureType .= '|null';
            }
        } else {
            $signatureType = 'mixed';
        }

        // Get parameter type from phpDoc
        $phpDocType = $this->phpDocParser->getParamTypehint($parameter->getName(), $this->method->getDocComment() ?: '');
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
        if ($this->method->hasReturnType()) {
            $signatureType = (string)$this->method->getReturnType();
        } else {
            $signatureType = 'mixed';
        }

        // Get return type from phpDoc
        $phpDocType = $this->phpDocParser->getReturnTypehint($this->method->getDocComment() ?: '');
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

        return $this->resolver->resolve($phpDocType, $this->resolverContext);
    }
}
