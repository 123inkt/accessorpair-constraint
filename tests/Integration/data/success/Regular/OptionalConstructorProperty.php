<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class OptionalConstructorProperty
{
    private ?int $property = null;

    public function __construct(array $data = [])
    {
        if (count($data) > 0) {
            $this->property = (int)$data['property'];
        }
    }

    public function getProperty(): ?int
    {
        return $this->property;
    }

    public function setProperty(?int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
