<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Test;

use DigitalRevolution\AccessorPairConstraint\AccessorPairAsserter;
use DigitalRevolution\AccessorPairConstraint\Constraint\ConstraintConfig;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionAttribute;
use ReflectionClass;

abstract class AbstractDtoTestCase extends TestCase
{
    use AccessorPairAsserter;

    public function testModel(): void
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(CoversClass::class, ReflectionAttribute::IS_INSTANCEOF);
        $testedAttributes = false;
        foreach ($attributes as $attribute) {
            if ($attribute->getName() !== CoversClass::class) {
                continue;
            }

            $testedAttributes = true;
            $config = $this->getAccessorPairConfig();

            /** @var array{0: class-string} $arguments */
            $arguments = $attribute->getArguments();

            $className = $arguments[0];
            $reflectionClass = new ReflectionClass($className);
            if ($reflectionClass->isAbstract()) {
                continue;
            }

            static::assertAccessorPairs($className, $config);
        }
        static::assertTrue($testedAttributes, 'Missing CoversClass attribute');
    }

    protected function getAccessorPairConfig(): ConstraintConfig
    {
        return (new ConstraintConfig())->setAssertPropertyDefaults(true);
    }
}
