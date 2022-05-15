<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class ClassStringProperty
{
    /** @var class-string */
    private string $property;

    /** @var class-string<ClassStringProperty> */
    private string $propertyFqsen;

    /**
     * @return class-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param class-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return class-string<ClassStringProperty>
     */
    public function getPropertyFqsen(): string
    {
        return $this->propertyFqsen;
    }

    /**
     * @param class-string<ClassStringProperty> $propertyFqsen
     */
    public function setPropertyFqsen(string $propertyFqsen): self
    {
        $this->propertyFqsen = $propertyFqsen;

        return $this;
    }
}
