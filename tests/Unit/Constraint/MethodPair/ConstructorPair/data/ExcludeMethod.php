<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data;

use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractDataClass;

class ExcludeMethod extends AbstractDataClass
{
    /** @var string */
    private $propertyA;

    /** @var string */
    private $propertyB;

    public function __construct(string $propertyA, string $propertyB)
    {
        $this->propertyA = $propertyA;
        $this->propertyB = $propertyB;
    }

    public function getPropertyA(): string
    {
        return $this->propertyA;
    }

    public function getPropertyB(): string
    {
        return $this->propertyB;
    }

    public function getConfig(): ConstraintConfig
    {
        return (new ConstraintConfig())->setExcludedMethods(['getPropertyB']);
    }

    public function getExpectedPairs(): array
    {
        return [['getPropertyA', 'propertyA']];
    }
}
