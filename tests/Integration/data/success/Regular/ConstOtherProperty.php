<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class ConstOtherProperty
{
    /** @var ConstSelfProperty::CONSTANT_* */
    private string $property;

    /**
     * @return ConstSelfProperty::CONSTANT_*
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param ConstSelfProperty::CONSTANT_* $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
