[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF)](https://php.net/)

# AccessorPair Constraint
A way to automatically unit test (and cover) all getter and setters of your data class.

## Installation
```
$ composer require --dev digitalrevolution/accessorpair-constraint
```

## Usage
Once you've imported the AccessorPairAsserter trait into your own test class,
or TestCase base class, you can call the ```assertAccessorPairs``` method to automatically test all your getters/setters.  
If you want to keep track of the coverage, configure the PHPUnit annotation to cover all methods of your class.

Optionally, the asserter can also check the initial values of all your class properties and whether or not calling the getter before having called the setter will work.

### Example
```php
<?php

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DataClass
 * @covers ::<public>
 */
class DataClassTest extends TestCase
{
    use AccessorPairAsserter;

    public function testDataClass()
    {
        static::assertAccessorPairs(DataClass::class);
    }
}
```

#### Example: Simple DataClass
In this example the data class consists of getter and setter methods and a constructor to set the properties.
The AccessorPair constraint can match the setter methods with the getter methods and will execute tests for each pair.
The constraint is also able to match the constructor parameters with the getter methods and will test these pairs as well.
```php
<?php

class DataClass
{
    private $property;
    private $default;

    public function __construct(string $property, bool $default)
    {
        $this->property = $property;
        $this->default  = $default;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $param): self
    {
        $this->property = $param;

        return $this;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    public function setDefault(bool $param): self
    {
        $this->default = $param;

        return $this;
    }
}
```

#### Example: Configuring the constraint
In this example the constructor parameter $property will be matched with the method getProperty, and the method setProperty with getProperty.
Because the constructor changes the data, it is not possible for the AccessorPair constraint to assert the correct working of your class.
It is still possible to test the method pair setProperty-getProperty using the constraint config.

##### The data class
```php
<?php

class DataClass
{
    private $property;

    public function __construct(string $property)
    {
        $this->property = strtoupper($property);
    }

    public  function setProperty(string $property)
    {
        $this->property = $property;
    }

    public function getProperty(): string
    {
        return $this->property;
    }
}
```

##### The unittest
```php
<?php

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DataClass
 * @covers ::<public>
 */
class DataClassTest extends TestCase
{
    use AccessorPairAsserter;

    public function testDataClass()
    {
        static::assertAccessorPairs(DataClass::class, (new ConstraintConfig())->setAssertConstructor(false));
    }
}
```

##### Possible configuration options
```php
<?php

class ConstraintConfig
{
    /**
     * Enabled by default.
     * Let the constraint pair all getter and setter methods,
     * and pass test data to the setter to assert that the getter returns the exact same value.
     */
    public function setAssertAccessorPair(bool $assertAccessorPair);
    
    /**
     * Enabled by default.
     * Let the constraint pair the constructor's parameters with the class' getter methods.
     * These pairs will be tested in the same ways as the getter/setter method pairs.
     */
    public function setAssertConstructor(bool $assertConstructor);
    
    /**
     * Disabled by default.
     * When enabled, the getter methods are called on an empty instance of the test object.
     * This makes sure that all the properties have the correct default type,
     * conforming the getter return typehint.
     */
    public function setAssertPropertyDefaults(bool $assertPropertyDefaults);

    /**
     * Callback function to create the constructor arguments for the class under test.
     *
     * Test data or mocks will be used by default.
     *
     * @param callable(): mixed[] $callback
     * @return $this
     */
    public function setConstructorCallback(callable $callback): self;
}
```

## About us
At 123inkt (Part of Digital Revolution B.V.), every day more than 30 developers are working on improving our internal ERP and our several shops. Do you want to join us? [We are looking for developers](https://www.123inkt.nl/page/werken_ict.html).
