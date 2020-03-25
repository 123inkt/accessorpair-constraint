<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\FalseType;
use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\Types\TrueType;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IterableProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ObjectProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\FalseProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Keyword\TrueProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\BoolProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\ResourceProvider;
use LogicException;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Callable_;
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

        // Support nullable typehints, such as "?string". Adds a NullProvider to the regular typehint's valueprovider.
        if ($typehint instanceof Nullable) {
            return new ValueProviderList(new NullProvider(), $this->getProvider($typehint->getActualType()));
        }

        // Typed array typehint, for example "int[]"
        if ($typehint instanceof Array_ && $typehint->getValueType() instanceof Mixed_ === false) {
            return new ArrayProvider($this->getProvider($typehint->getValueType()));
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

        throw new LogicException("No value provider found for typehint: " . $typehint);
    }

    /**
     * @return ValueProvider|null
     */
    protected function getNativeTypeProvider(Type $typehint)
    {
        switch (get_class($typehint)) {
            // Compound valueProviders
            case Array_::class:
                return new ArrayProvider();
            case Callable_::class:
                return new CallableProvider();
            case Iterable_::class:
                return new IterableProvider();
            case Object_::class:
                return new ObjectProvider();
            // Keyword valueProviders
            case TrueType::class:
                return new TrueProvider();
            case FalseType::class:
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
