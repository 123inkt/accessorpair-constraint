<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class LiteralStringProvider implements ValueProvider
{
    /**
     * @return literal-string[]
     */
    public function getValues(): array
    {
        return [
            "hello world",
            implode(', ', ["one", "two"]),
            implode(', ', [1, 2, 3])
        ];
    }
}
