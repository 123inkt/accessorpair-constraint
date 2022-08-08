<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

use DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\TestEnum;

if (PHP_VERSION_ID >= 80100) {
    class EnumProperty
    {
        private TestEnum $property;

        public function getProperty(): TestEnum
        {
            return $this->property;
        }

        public function setProperty(TestEnum $property): self
        {
            $this->property = $property;

            return $this;
        }
    }
} else {
    // phpcs:ignore PSR1.Classes.ClassDeclaration.MultipleClasses
    class EnumProperty
    {
    }
}
