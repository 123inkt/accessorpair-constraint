<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

/**
 * @template T of string
 */
class TemplateProperty
{
    /** @phpstan-var T */
    private $property;

    /**
     * @phpstan-return T
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @phpstan-param T $property
     */
    public function setProperty($property): self
    {
        $this->property = $property;

        return $this;
    }
}
