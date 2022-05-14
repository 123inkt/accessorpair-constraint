<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\ArrayProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\CallableProvider;
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
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Iterable_;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Resource_;
use phpDocumentor\Reflection\Types\String_;
use phpDocumentor\Reflection\PseudoTypes\False_;
use phpDocumentor\Reflection\PseudoTypes\True_;

class NativeValueProviderFactory
{
    private ValueProviderFactory $valueProviderFactory;

    public function __construct(ValueProviderFactory $valueProviderFactory)
    {
        $this->valueProviderFactory = $valueProviderFactory;
    }

    /**
     * @throws LogicException
     */
    public function getProvider(Type $typehint): ?ValueProvider
    {
        $provider = $this->getCompoundProvider($typehint);
        if ($provider !== null) {
            return $provider;
        }

        $provider = $this->getKeywordProvider($typehint);
        if ($provider !== null) {
            return $provider;
        }

        $provider = $this->getScalarProvider($typehint);
        if ($provider !== null) {
            return $provider;
        }

        $provider = $this->getSpecialProvider($typehint);
        if ($provider !== null) {
            return $provider;
        }

        return null;
    }

    protected function getCompoundProvider(Type $typehint)
    {
        switch (get_class($typehint)) {
            case Array_::class:
                return new ArrayProvider(
                    $this->valueProviderFactory->getProvider($typehint->getValueType()),
                    $this->valueProviderFactory->getProvider($typehint->getKeyType())
                );
            case Callable_::class:
                return new CallableProvider();
            case Iterable_::class:
                return new IterableProvider();
            case Object_::class:
                return new ObjectProvider();
            default:
                return null;
        }
    }

    protected function getKeywordProvider(Type $typehint)
    {
        switch (get_class($typehint)) {
            case True_::class:
                return new TrueProvider();
            case False_::class:
                return new FalseProvider();
            default:
                return null;
        }
    }

    protected function getScalarProvider(Type $typehint)
    {
        switch (get_class($typehint)) {
            case Boolean::class:
                return new BoolProvider();
            case Float_::class:
                return new FloatProvider(new IntProvider());
            case Integer::class:
                return new IntProvider();
            case String_::class:
                return new StringProvider();
            default:
                return null;
        }
    }

    protected function getSpecialProvider(Type $typehint)
    {
        switch (get_class($typehint)) {
            case Null_::class:
                return new NullProvider();
            case Resource_::class:
                return new ResourceProvider();
            case Mixed_::class:
                return $this->getMixedProvider();
            default:
                return null;
        }
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
}
