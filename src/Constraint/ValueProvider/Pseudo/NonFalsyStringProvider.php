<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class NonFalsyStringProvider implements ValueProvider
{
    private StringProvider $stringProvider;

    public function __construct(StringProvider $stringProvider)
    {
        $this->stringProvider = $stringProvider;
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public function getValues(): array
    {
        return array_values(array_filter(
            $this->stringProvider->getValues(),
            static fn(string $value): bool => $value !== '' && $value !== '0'
        ));
    }
}
