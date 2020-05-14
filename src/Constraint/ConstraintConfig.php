<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint;

class ConstraintConfig
{
    /** @var bool */
    private $assertAccessorPair = true;

    /** @var bool */
    private $assertConstructor = true;

    /** @var bool */
    private $assertPropertyDefaults = false;

    public function hasAccessorPairCheck(): bool
    {
        return $this->assertAccessorPair;
    }

    /**
     * Enabled by default.
     * Let the constraint pair all getter and setter methods,
     * and pass test data to the setter to assert that the getter returns the exact same value.
     */
    public function setAssertAccessorPair(bool $assertAccessorPair): self
    {
        $this->assertAccessorPair = $assertAccessorPair;

        return $this;
    }

    public function hasAssertConstructor(): bool
    {
        return $this->assertConstructor;
    }

    /**
     * Enabled by default.
     * Let the constraint pair the constructor's parameters with the class' getter methods.
     * These pairs will be tested in the same ways as the getter/setter method pairs.
     */
    public function setAssertConstructor(bool $assertConstructor): self
    {
        $this->assertConstructor = $assertConstructor;

        return $this;
    }

    public function hasPropertyDefaultCheck(): bool
    {
        return $this->assertPropertyDefaults;
    }

    /**
     * Disabled by default.
     * When enabled, the getter methods are called on an empty instance of the test object.
     * This makes sure that all the properties have the correct default type,
     * conforming the getter return typehint.
     */
    public function setAssertPropertyDefaults(bool $assertPropertyDefaults): self
    {
        $this->assertPropertyDefaults = $assertPropertyDefaults;

        return $this;
    }
}
