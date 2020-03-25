<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\failure\Regular;

use LogicException;

class GetterException
{
    /** @var string */
    private $property;

    public function getProperty(): string
    {
        throw new LogicException("Exception thrown");
    }

    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
