<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use ArrayIterator;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Generator;

class IterableProvider implements ValueProvider
{
    /**
     * @return iterable[]
     */
    public function getValues(): array
    {
        return [
            [1, 2, 3],
            new ArrayIterator([1, 2, 3]),
            (static function (): Generator {
                yield 1; // @codeCoverageIgnore
            })()
        ];
    }
}
