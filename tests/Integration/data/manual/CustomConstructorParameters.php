<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\manual;

class CustomConstructorParameters
{
    /** @var SetterTransformer */
    private $transformer;

    /** @var EmptyClass */
    private $value;

    public function __construct(SetterTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function setValue(EmptyClass $data): self
    {
        $this->value = $this->transformer->transform($data);

        return $this;
    }

    public function getValue(): ?EmptyClass
    {
        return $this->value;
    }
}
