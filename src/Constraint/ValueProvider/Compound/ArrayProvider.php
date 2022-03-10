<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class ArrayProvider implements ValueProvider
{
    /** @var ValueProvider|null */
    protected $valueProvider;

    public function __construct(ValueProvider $valueProvider = null)
    {
        $this->valueProvider = $valueProvider;
    }

    /**
     * @return array<int, mixed[]>
     * @inheritDoc
     */
    public function getValues(): array
    {
        if ($this->valueProvider !== null) {
            $testValues = [];
            foreach ($this->valueProvider->getValues() as $testValue) {
                $testValues[] = [$testValue];
            }

            return $testValues;
        }

        return [
            [],
            [1],
            [1.0],
            ['string'],
            [null]
        ];
    }
}
