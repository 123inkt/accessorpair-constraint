<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual;

use stdClass;
use Countable;

class IntersectionClassProperty
{
    private stdClass&Countable $property;

    public function getProperty(): stdClass&Countable
    {
        return $this->property;
    }

    public function setProperty(stdClass&Countable $property): self
    {
        $this->property = $property;

        return $this;
    }
}
