<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\IntersectionProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider;
use LogicException;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Collection;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Intersection;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\Object_;
use ReflectionMethod;

class ValueProviderFactory
{
    private NativeValueProviderFactory $nativeProviderFactory;
    private PseudoValueProviderFactory $pseudoProviderFactory;

    public function __construct()
    {
        $this->nativeProviderFactory = new NativeValueProviderFactory($this);
        $this->pseudoProviderFactory = new PseudoValueProviderFactory($this);
    }

    /**
     * Return a valueProvider based on the provided typehint
     *
     * @throws LogicException
     */
    public function getProvider(Type $typehint, ?ReflectionMethod $method = null): ValueProvider
    {
        // Support intersection typehints, such as "Iterator&Countable"
        if ($typehint instanceof Intersection) {
            return new IntersectionProvider(iterator_to_array($typehint));
        }

        // Support union typehints, such as "string|null"
        if ($typehint instanceof Compound) {
            return new ValueProviderList(...$this->getProviders(iterator_to_array($typehint), $method));
        }

        // Support nullable typehints, such as "?string". Adds a NullProvider to the regular typehint's ValueProvider.
        if ($typehint instanceof Nullable) {
            return new ValueProviderList(new NullProvider(), $this->getProvider($typehint->getActualType(), $method));
        }

        // Support for fully namespaced class name
        if (($typehint instanceof Object_ || $typehint instanceof Collection) && $typehint->getFqsen() !== null) {
            /** @var class-string $fqsen */
            $fqsen = (string)$typehint->getFqsen();

            return new InstanceProvider($fqsen);
        }

        // Check if the provider typehint is a PHP scalar type
        $nativeProvider = $this->nativeProviderFactory->getProvider($typehint, $method);
        if ($nativeProvider !== null) {
            return $nativeProvider;
        }

        // Check if the provider typehint is a PHP pseudoType
        $pseudoProvider = $this->pseudoProviderFactory->getProvider($typehint, $method);
        if ($pseudoProvider !== null) {
            return $pseudoProvider;
        }

        throw new LogicException("No value provider found for typehint: " . $typehint);
    }

    /**
     * @param Type[] $typehints
     *
     * @return ValueProvider[]
     * @throws LogicException
     */
    protected function getProviders(array $typehints, ?ReflectionMethod $method): array
    {
        $providers = [];
        foreach ($typehints as $typehint) {
            $providers[] = $this->getProvider($typehint, $method);
        }

        return $providers;
    }
}
