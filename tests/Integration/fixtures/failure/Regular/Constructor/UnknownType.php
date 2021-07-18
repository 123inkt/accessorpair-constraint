<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\failure\Regular\Constructor;

class UnknownType
{
    /** @var unknown */
    private $property;

    /**
     * @param unknown $property
     */
    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * @return unknown
     */
    public function getProperty()
    {
        return $this->property;
    }
}
