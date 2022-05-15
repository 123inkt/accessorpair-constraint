<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\PseudoTypes;

class HtmlEscapedStringProperty
{
    /** @var html-escaped-string */
    private string $property;

    /**
     * @return html-escaped-string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param html-escaped-string $property
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }
}
