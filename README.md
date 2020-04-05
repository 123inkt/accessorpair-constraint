# AccessorPair Constraint
A way to automatically unit test (and cover) all getter and setters of your data class.

## Installation
```
$ composer require --dev digitalrevolution/accessorpair-constraint
```

## Usage
Once you've imported the AccessorPairAsserter trait into your own testclass,
or TestCase base class, you can call the ```assertAccessorPairs``` method to automatically test all your getters/setters.  
If you want to keep track of the coverage, configure the PHPUnit annotation to cover all methods of your class.

Optionally, the asserter can also check the initial values of all your class properties and whether or not calling the getter before having called the setter will work.

### Example
```php
<?php

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use PHPUnit\Framework\TestCase;

class DataClassTest extends TestCase
{
    use AccessorPairAsserter;

    /**
     * @covers DataClass::<public>
     */
    public function testDataClass()
    {
        static::assertAccessorPairs(DataClass::class);
    }
}
```

#### Example: DataClass with getters and setters
In this example the data class consists of getter and setter methods.
The AccessorPair constraint can match the setter methods with the getter methods and will execute tests for each pair.
```php
class DataClass
{
    /** @var string */
    private $property;

    /** @var string */
    private $default;

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $param): self
    {
        $this->property = $param;

        return $this;
    }

    public function getDefault(): string
    {
        return $this->default;
    }

    public function setDefault(string $param): self
    {
        $this->default= $param;

        return $this;
    }
}
```

#### Example: DataClass with the constructor as a setter
In this example the constructor is used to set the value of some properties.   
The AccessorPair constraint can match the constructor's parameters with the getter methods and will execute tests for each pair.
```php
class DataClass
{
    /** @var string */
    private $property;

    /** @var string */
    private $default;

    public function __construct(string $property, string $default)
    {
        $this->property = $property;
        $this->default  = $default;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getDefault(): string
    {
        return $this->default;
    }
}
```

## About us
At 123inkt (Part of Digital Revolution B.V.), every day more than 30 developers are working on improving our internal ERP and our several shops. Do you want to join us? [We are looking for developers](https://www.123inkt.nl/page/werken_ict.html).
