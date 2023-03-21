<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

if (PHP_MAJOR_VERSION >= 8) {
    class UnionNullableProperty
    {
        private int|string|null $property;

        public function getProperty(): int|string|null
        {
            return $this->property;
        }

        public function setProperty(int|string|null $property): self
        {
            $this->property = $property;

            return $this;
        }
    }
} else {
    // phpcs:ignore PSR1.Classes.ClassDeclaration.MultipleClasses
    class UnionNullableProperty
    {
    }
}
