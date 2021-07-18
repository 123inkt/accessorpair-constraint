<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\failure\Regular;

class IncorrectOptionalReturnValue
{
    /** @var string */
    private $property;

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $property = '__DEFAULT__'): self
    {
        if ($property === '__DEFAULT__') {
            $property = '__FOOBAR__';
        }

        $this->property = $property;

        return $this;
    }
}
