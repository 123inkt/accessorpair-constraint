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

## About us
At 123inkt (Part of Digital Revolution B.V.), every day more than 30 developers are working on improving our internal ERP and our several shops. Do you want to join us? [We are looking for developers](https://www.123inkt.nl/page/werken_ict.html).
