<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class ListProvider implements ValueProvider
{
    protected ?ValueProvider $valueProvider;

    public function __construct(ValueProvider $valueProvider = null)
    {
        $this->valueProvider = $valueProvider;
    }

    /**
     * @return array<int, array<int, mixed>>
     * @inheritDoc
     */
    public function getValues(): array
    {
        if ($this->valueProvider !== null) {
            $testArray = [];
            foreach ($this->valueProvider->getValues() as $value) {
                $testArray[] = $value;
            }

            return [$testArray];
        }

        return [[], [1], [1.0], ['string'], [null]];
    }
}
