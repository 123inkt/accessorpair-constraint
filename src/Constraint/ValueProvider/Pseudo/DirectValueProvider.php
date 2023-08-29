<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use phpDocumentor\Reflection\PseudoTypes\FloatValue;
use phpDocumentor\Reflection\PseudoTypes\IntegerValue;
use phpDocumentor\Reflection\PseudoTypes\StringValue;

class DirectValueProvider implements ValueProvider
{
    /** @var FloatValue|IntegerValue|StringValue */
    private $valueType;

    /**
     * @param FloatValue|IntegerValue|StringValue $valueType
     */
    public function __construct($valueType)
    {
        $this->valueType = $valueType;
    }

    /**
     * @return float[]|int[]|string[]
     */
    public function getValues(): array
    {
        return [$this->valueType->getValue()];
    }
}
