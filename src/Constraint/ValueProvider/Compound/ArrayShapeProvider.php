<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class ArrayShapeProvider implements ValueProvider
{
    /**
     * @param array<string, ValueProvider> $items
     */
    public function __construct(protected array $items)
    {
    }

    /**
     * @return array<array<int|string, mixed>>
     * @inheritDoc
     */
    public function getValues(): array
    {
        $testArray = [];
        $keyValues = [];

        $minValues = null;
        foreach ($this->items as $key => $item) {
            $values = $item->getValues();
            if ($minValues === null || count($values) < $minValues) {
                $minValues = count($values);
            }
            $keyValues[$key] = $item->getValues();
        }

        foreach ($keyValues as $key => $values) {
            $keyValues[$key] = array_slice($values, 0, $minValues);
        }

        foreach ($keyValues as $key => $values) {
            foreach ($values as $index => $value) {
                $testArray[$index][$key] = $value;
            }
        }

        return $testArray;
    }
}
