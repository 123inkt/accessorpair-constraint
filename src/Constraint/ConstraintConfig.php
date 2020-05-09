<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint;

class ConstraintConfig
{
    /** @var bool */
    private $accessorPairCheck = true;

    /** @var bool */
    private $constructorPairCheck = true;

    /** @var bool */
    private $propertyDefaultCheck = false;

    public function hasAccessorPairCheck(): bool
    {
        return $this->accessorPairCheck;
    }

    /**
     * Let the constraint pair all getter and setter methods,
     * and pass test data to the setter to assert that the getter returns the exact same value.
     */
    public function setAccessorPairCheck(bool $accessorPairCheck): self
    {
        $this->accessorPairCheck = $accessorPairCheck;

        return $this;
    }

    public function hasConstructorPairCheck(): bool
    {
        return $this->constructorPairCheck;
    }

    /**
     * Let the constraint pair the constructor's parameters with the class' getter methods.
     * These pairs will be tested in the same ways as the getter/setter method pairs.
     */
    public function setConstructorPairCheck(bool $constructorPairCheck): self
    {
        $this->constructorPairCheck = $constructorPairCheck;

        return $this;
    }

    public function hasPropertyDefaultCheck(): bool
    {
        return $this->propertyDefaultCheck;
    }

    /**
     * When true, the getter methods are called on an empty instance of the test object.
     * This makes sure that all the properties have the correct default type,
     * conforming the getter return typehint.
     */
    public function setPropertyDefaultCheck(bool $propertyDefaultCheck): self
    {
        $this->propertyDefaultCheck = $propertyDefaultCheck;

        return $this;
    }
}
