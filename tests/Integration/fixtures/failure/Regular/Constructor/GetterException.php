<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\failure\Regular\Constructor;

use LogicException;

class GetterException
{
    /** @var string */
    private $property;

    public function __construct(string $property)
    {
        $this->property = $property;
    }

    public function getProperty(): string
    {
        throw new LogicException("Exception thrown: " . $this->property);
    }
}
