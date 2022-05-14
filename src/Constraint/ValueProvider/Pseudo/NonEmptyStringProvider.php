<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class NonEmptyStringProvider implements ValueProvider
{
    /** @var LowercaseStringProvider|StringProvider */
    private $stringProvider;

    /**
     * @param LowercaseStringProvider|StringProvider $stringProvider
     */
    public function __construct($stringProvider)
    {
        $this->stringProvider = $stringProvider;
    }

    /**
     * @return non-empty-string[]
     * @throws Exception
     */
    public function getValues(): array
    {
        return array_filter($this->stringProvider->getValues());
    }
}
