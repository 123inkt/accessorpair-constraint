<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class ConstSelfProperty
{
    public const CONSTANT_1 = 'value1';
    public const CONSTANT_2 = 'value2';

    /** @var self::CONSTANT_* */
    private string $property;

    /**
     * @return self::CONSTANT_*
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param self::CONSTANT_* $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
