<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Type\NonEmptyUppercaseStringType;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Type\UppercaseStringType;
use LogicException;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\ContextFactory;
use phpDocumentor\Reflection\Types\Nullable;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;

/**
 * Resolve the PHP signature's typehint + parse the PHPDoc's typehint and turn into a Type object
 */
class TypehintResolver
{
    protected PhpDocParser $phpDocParser;
    protected ReflectionMethod $method;
    protected TypeResolver $resolver;
    protected Context $resolverContext;

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

    /**
     * Turn PHP's reflection type object into typehint string
     * Resolved union/intersection/nullable types
     */
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
            if ($signatureType !== 'null' && $type->allowsNull()) {
                $signatureType = '?' . $signatureType;
            }

            return $signatureType;
        }

        return 'mixed';
    }

    /**
     * Turns typehint string into PHPDocumentor Type object
     */
    protected function resolveTypes(string $signatureType, string $phpDocType): Type
    {
        $phpDocType = $this->resolveTemplateTypes($phpDocType) ?? $phpDocType;

        // If one is mixed, return the other
        if ($phpDocType === 'mixed' && $signatureType !== 'mixed') {
            return $this->resolver->resolve($signatureType);
        }

        $phpDocType = str_replace(' ', '', $phpDocType);

        $customType = $this->resolveCustomType($phpDocType);
        if ($customType !== null) {
            return $customType;
        }

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

    protected function resolveCustomType(string $phpDocType): ?Type
    {
        return match ($phpDocType) {
            'uppercase-string' => new UppercaseStringType(),
            'non-empty-uppercase-string' => new NonEmptyUppercaseStringType(),
            '?uppercase-string' => new Nullable(new UppercaseStringType()),
            '?non-empty-uppercase-string' => new Nullable(new NonEmptyUppercaseStringType()),
            default => null,
        };
    }
}
