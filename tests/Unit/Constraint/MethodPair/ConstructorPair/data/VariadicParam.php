<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class VariadicParam extends AbstractDataClass
{
    /** @var string[] */
    private $property;

    public function __construct(string ...$property)
    {
        $this->property = $property;
    }

    /**
     * @return string[]
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperty', 'property']];
    }
}
