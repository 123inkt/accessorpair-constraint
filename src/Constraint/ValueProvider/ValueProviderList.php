<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;

use Exception;
use LogicException;

class ValueProviderList implements ValueProvider
{
    /** @var ValueProvider[] */
    protected $valueProviders;

    public function __construct(ValueProvider ...$valueProviders)
    {
        $this->valueProviders = $valueProviders;

        if (count($this->valueProviders) === 0) {
            throw new LogicException("Missing valueProviders");
        }
    }

    /**
     * @return mixed[]
     * @throws Exception
     */
    public function getValues(): array
    {
        $testValueLists = [];
        foreach ($this->valueProviders as $provider) {
            $testValues = $provider->getValues();
            if (count($testValues) === 0) {
                throw new LogicException("No test values retrieved for provider " . get_class($provider));
            }

            $testValueLists[] = $testValues;
        }

        return array_merge(...$testValueLists);
    }
}
