<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;

class FloatProvider implements ValueProvider
{
    /** @var IntProvider */
    protected $intProvider;

    public function __construct(IntProvider $intProvider)
    {
        $this->intProvider = $intProvider;
    }

    /**
     * @return float[]
     * @throws Exception
     */
    public function getValues(): array
    {
        $testValues = [];
        foreach ($this->intProvider->getValues() as $intValue) {
            $testValues[] = (float)$intValue;
        }

        return array_merge(
            $testValues,
            [
                (float)0,
                (float)random_int(PHP_INT_MIN, -1),
                (float)random_int(1, PHP_INT_MAX),
                (float)(random_int(0, 1000000) / random_int(1, 50)),
                (float)(-random_int(0, 1000000) / random_int(1, 50))
            ]
        );
    }
}
