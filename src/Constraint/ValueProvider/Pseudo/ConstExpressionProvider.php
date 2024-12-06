<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Self_;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;

class ConstExpressionProvider implements ValueProvider
{
    protected Type $owner;
    protected string $expression;
    protected ?ReflectionMethod $method;

    public function __construct(Type $owner, string $expression, ?ReflectionMethod $method)
    {
        $this->owner = $owner;
        $this->expression = $expression;
        $this->method = $method;
    }

    /**
     * @inheritDoc
     */
    public function getValues(): array
    {
        if ($this->owner instanceof Object_ && $this->owner->getFqsen() !== null) {
            $constClass = new ReflectionClass((string)$this->owner->getFqsen());
        } elseif ($this->owner instanceof Self_ && $this->method !== null) {
            $constClass = $this->method->getDeclaringClass();
        } else {
            throw new RuntimeException('ConstExpressionProvider can only be used with object or self typehints');
        }

        $constants = $constClass->getConstants();
        $expression = str_replace('*', '.*', $this->expression);
        $values = [];
        foreach ($constants as $constant => $value) {
            if (preg_match('/^' . $expression . '$/', $constant) === 1) {
                $values[] = $value;
            }
        }

        return $values;
    }
}
