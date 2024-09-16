<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint;

use phpDocumentor\Reflection\Type;

class ConstraintConfig
{
    /** @var bool */
    private $assertAccessorPair = true;

    /** @var bool */
    private $assertConstructor = true;

    /** @var bool */
    private $assertPropertyDefaults = false;

    /** @var bool */
    private $assertParentMethods = true;

    /** @var string[] */
    private $excludedMethods = [];

    /** @var null|callable(): mixed[] */
    private $constructorCallback = null;

    /** @var null|(callable(class-string): ?object) */
    private $valueProvider = null;

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

    public function isAssertParentMethods(): bool
    {
        return $this->assertParentMethods;
    }

    /**
     * Enabled by default.
     * When disabled, only the direct class methods will be asserted and none of the parent's
     * class methods.
     */
    public function setAssertParentMethods(bool $assertParentMethods): self
    {
        $this->assertParentMethods = $assertParentMethods;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getExcludedMethods(): array
    {
        return $this->excludedMethods;
    }

    /**
     * @param string[] $excludedMethods A list of exact method names that should be excluded from the assertions.
     */
    public function setExcludedMethods(array $excludedMethods): self
    {
        $this->excludedMethods = $excludedMethods;

        return $this;
    }

    public function getConstructorCallback(): ?callable
    {
        return $this->constructorCallback;
    }

    /**
     * Callback function to create the constructor arguments for the class under test.
     *
     * Test data or mocks will be used by default.
     *
     * @param callable(): mixed[] $callback
     * @return $this
     */
    public function setConstructorCallback(callable $callback): self
    {
        $this->constructorCallback = $callback;

        return $this;
    }

    public function getValueProvider(): ?callable
    {
        return $this->valueProvider;
    }

    /**
     * Callback function to allow for a custom value provider. For instance for final classes. The argument
     * is the class-string of the value, the return value should be the provided value. Return <code>null</code>
     * to skip the value provider and use the default value providers.
     *
     * @param callable(class-string): ?object $valueProvider
     */
    public function setValueProvider(callable $valueProvider): self
    {
        $this->valueProvider = $valueProvider;

        return $this;
    }
}
