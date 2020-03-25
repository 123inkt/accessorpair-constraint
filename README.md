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

Optionally, the asserter can also check the initial values of all your class properties and whether or not directly calling the getter will work.

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
