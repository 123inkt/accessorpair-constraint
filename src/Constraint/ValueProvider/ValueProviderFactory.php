<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\TrueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LowercaseStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NonEmptyStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\TraitStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\ResourceProvider;
use LogicException;
use phpDocumentor\Reflection\PseudoTypes\CallableString;
use phpDocumentor\Reflection\PseudoTypes\False_;
use phpDocumentor\Reflection\PseudoTypes\HtmlEscapedString;
use phpDocumentor\Reflection\PseudoTypes\IntegerRange;
use phpDocumentor\Reflection\PseudoTypes\List_;
use phpDocumentor\Reflection\PseudoTypes\LiteralString;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;
use phpDocumentor\Reflection\PseudoTypes\NegativeInteger;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyLowercaseString;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyString;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use phpDocumentor\Reflection\PseudoTypes\NumericString;
use phpDocumentor\Reflection\PseudoTypes\PositiveInteger;
use phpDocumentor\Reflection\PseudoTypes\TraitString;
use phpDocumentor\Reflection\PseudoTypes\True_;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\ArrayKey;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Callable_;
use phpDocumentor\Reflection\Types\ClassString;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Iterable_;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Resource_;
use phpDocumentor\Reflection\Types\String_;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ValueProviderFactory
{
    /**
     * Return a valueProvider based on the provided typehint
     *
     * @throws LogicException
     */
    public function getProvider(Type $typehint): ValueProvider
    {
        // Support union typehints, such as "string|null"
        if ($typehint instanceof Compound) {
            return new ValueProviderList(...$this->getProviders(iterator_to_array($typehint)));
        }

        // Support nullable typehints, such as "?string". Adds a NullProvider to the regular typehint's ValueProvider.
        if ($typehint instanceof Nullable) {
            return new ValueProviderList(new NullProvider(), $this->getProvider($typehint->getActualType()));
        }

        // Support for fully namespaced class name
        if ($typehint instanceof Object_ && $typehint->getFqsen() !== null) {
            return new InstanceProvider((string)$typehint->getFqsen());
        }

        // Check if the provider typehint is a PHP scalar type
        $scalarProvider = $this->getNativeTypeProvider($typehint);
        if ($scalarProvider !== null) {
            return $scalarProvider;
        }

        // Check if the provider typehint is a PHP pseudoType
        $pseudoProvider = $this->getPseudoProvider($typehint);
        if ($pseudoProvider !== null) {
            return $pseudoProvider;
        }

        throw new LogicException("No value provider found for typehint: " . $typehint);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function getNativeTypeProvider(Type $typehint): ?ValueProvider
    {
        switch (get_class($typehint)) {
            // Compound valueProviders
            case Array_::class:
                return new ArrayProvider($this->getProvider($typehint->getValueType()), $this->getProvider($typehint->getKeyType()));
            case Callable_::class:
                return new CallableProvider();
            case Iterable_::class:
                return new IterableProvider();
            case Object_::class:
                return new ObjectProvider();
            // Keyword valueProviders
            case True_::class:
                return new TrueProvider();
            case False_::class:
                return new FalseProvider();
            // Scalar valueProviders
            case Boolean::class:
                return new BoolProvider();
            case Float_::class:
                return new FloatProvider(new IntProvider());
            case Integer::class:
                return new IntProvider();
            case String_::class:
                return new StringProvider();
            // Special valueProviders
            case Null_::class:
                return new NullProvider();
            case Resource_::class:
                return new ResourceProvider();
            // Unknown/Mixed valueProviders
            case Mixed_::class:
                return $this->getMixedProvider();
        }

        return null;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function getPseudoProvider(Type $typehint): ?ValueProvider
    {
        switch (get_class($typehint)) {
            case ArrayKey::class:
                return new ValueProviderList(new StringProvider(), new IntProvider());
            case ClassString::class:
                $fqsen = null;
                if ($typehint->getFqsen() !== null) {
                    /** @var class-string|null $fqsen */
                    $fqsen = (string)$typehint->getFqsen();
                }

                return new ClassStringProvider($fqsen);
            case CallableString::class:
                return new CallableStringProvider();
            case HtmlEscapedString::class:
                return new HtmlEscapedStringProvider();
            case IntegerRange::class:
                return new IntProvider((int)$typehint->getMinValue(), (int)$typehint->getMaxValue());
            case List_::class:
                return new ListProvider($this->getProvider($typehint->getValueType()));
            case LiteralString::class:
                return new LiteralStringProvider();
            case LowercaseString::class:
                return new LowercaseStringProvider(new StringProvider());
            case NegativeInteger::class:
                return new IntProvider(PHP_INT_MIN, -1);
            case NonEmptyLowercaseString::class:
                return new NonEmptyStringProvider(new LowercaseStringProvider(new StringProvider()));
            case NonEmptyString::class:
                return new NonEmptyStringProvider(new StringProvider());
            case Numeric_::class:
                return new ValueProviderList(new NumericStringProvider(), new IntProvider(), new FloatProvider(new IntProvider()));
            case NumericString::class:
                return new NumericStringProvider();
            case PositiveInteger::class:
                return new IntProvider(1, PHP_INT_MAX);
            case TraitString::class:
                return new TraitStringProvider();
        }

        return null;
    }

    /**
     * Return a ValueProvider returning "mixed" values
     */
    protected function getMixedProvider(): ValueProvider
    {
        return new ValueProviderList(
            new StringProvider(),
            new BoolProvider(),
            new IntProvider(),
            new FloatProvider(new IntProvider()),
            new ArrayProvider(),
            new ObjectProvider(),
            new CallableProvider(),
            new NullProvider()
        );
    }

    /**
     * @param Type[] $typehints
     *
     * @return ValueProvider[]
     * @throws LogicException
     */
    protected function getProviders(array $typehints): array
    {
        $providers = [];
        foreach ($typehints as $typehint) {
            $providers[] = $this->getProvider($typehint);
        }

        return $providers;
    }
}
