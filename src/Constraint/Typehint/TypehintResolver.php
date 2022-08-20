<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint;

use LogicException;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;

class TypehintResolver
{
    protected PhpDocParser     $phpDocParser;
    protected ReflectionMethod $method;
    protected TypeResolver     $resolver;
    protected Context          $resolverContext;

    public function __construct(ReflectionMethod $method)
    {
        $this->phpDocParser = new PhpDocParser();
        $this->method       = $method;

        // Set up the internal type resolver
        $this->resolverContext = (new ContextFactory())->createFromReflector($method);
        $this->resolver        = new TypeResolver();
    }

    /**
     * @throws LogicException
     */
    public function getParamTypehint(ReflectionParameter $parameter): Type
    {
        // Get parameter type from method signature
        $signatureType = $this->getReflectionType($parameter->getType());

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
        $signatureType = $this->getReflectionType($this->method->getReturnType());

        // Get return type from phpDoc
        $docComment = $this->method->getDocComment();
        $phpDocType = $this->phpDocParser->getReturnTypehint($docComment !== false ? $docComment : '');
        if ($phpDocType === null) {
            $phpDocType = 'mixed';
        }

        return $this->resolveTypes($signatureType, $phpDocType);
    }

    protected function getReflectionType(?ReflectionType $type): string
    {
        if ($type instanceof ReflectionIntersectionType) {
            $signatureType = [];
            foreach ($type->getTypes() as $subType) {
                $signatureType[] = $this->getReflectionType($subType);
            }

            return implode('&', $signatureType);
        }

        if ($type instanceof ReflectionUnionType) {
            $signatureType = [];
            foreach ($type->getTypes() as $subType) {
                $signatureType[] = $this->getReflectionType($subType);
            }

            return implode('|', $signatureType);
        }

        if ($type instanceof ReflectionNamedType) {
            $signatureType = $type->getName();
            if ($type->allowsNull()) {
                $signatureType = '?' . $signatureType;
            }

            return $signatureType;
        }

        return 'mixed';
    }

    protected function resolveTypes(string $signatureType, string $phpDocType): Type
    {
        $phpDocType = $this->resolveTemplateTypes($phpDocType) ?? $phpDocType;

        // If one is mixed, return the other
        if ($phpDocType === 'mixed' && $signatureType !== 'mixed') {
            return $this->resolver->resolve($signatureType);
        }

        $phpDocType = str_replace(' ', '', $phpDocType);

        return $this->resolver->resolve($phpDocType, $this->resolverContext);
    }

    /**
     * Replace the phpdoc type with a template type if configured
     */
    protected function resolveTemplateTypes(string $phpDocType): ?string
    {
        $docComment = $this->method->getDeclaringClass()->getDocComment();
        $templates  = $this->phpDocParser->getTemplateTypehints($docComment !== false ? $docComment : '');
        if (count($templates) === 0) {
            return $phpDocType;
        }

        $patterns = [];
        foreach (array_keys($templates) as $templateKey) {
            $patterns[] = '/(^|\W)(' . preg_quote($templateKey, '/') . ')(\W|$)/';
        }

        $replacements = [];
        foreach ($templates as $templateValue) {
            $replacements[] = '$1' . $templateValue . '$3';
        }

        return preg_replace($patterns, $replacements, $phpDocType);
    }
}
