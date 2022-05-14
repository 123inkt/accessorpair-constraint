<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound\InstanceProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special\NullProvider;
use LogicException;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\Object_;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ValueProviderFactory
{
    private NativeValueProviderFactory $nativeValueProviderFactory;
    private PseudoValueProviderFactory $pseudoValueProviderFactory;

    public function __construct()
    {
        $this->nativeValueProviderFactory = new NativeValueProviderFactory($this);
        $this->pseudoValueProviderFactory = new PseudoValueProviderFactory($this);
    }

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
        $nativeProvider = $this->nativeValueProviderFactory->getProvider($typehint);
        if ($nativeProvider !== null) {
            return $nativeProvider;
        }

        // Check if the provider typehint is a PHP pseudoType
        $pseudoProvider = $this->pseudoValueProviderFactory->getProvider($typehint);
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
    protected function getProviders(array $typehints): array
    {
        $providers = [];
        foreach ($typehints as $typehint) {
            $providers[] = $this->getProvider($typehint);
        }

        return $providers;
    }
}
