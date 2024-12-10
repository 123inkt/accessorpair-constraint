<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ConstExpressionProvider;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\AbstractValueProviderTestCase;
use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo\data\ClassWithConsts;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Callable_;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Self_;
use ReflectionMethod;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ConstExpressionProvider
 * @covers ::__construct
 */
class ConstExpressionProviderTest extends AbstractValueProviderTestCase
{
    /**
     * @covers ::getValues
     */
    public function testGetValues(): void
    {
        $valueProvider = new ConstExpressionProvider(new Object_(new Fqsen('\\' . ClassWithConsts::class)), 'CONST_*', null);
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['string']);
        static::assertContains('CONST_A', $values);
        static::assertContains('CONST_B', $values);
        static::assertNotContains('CONSTANT_A', $values);
    }

    /**
     * @covers ::getValues
     */
    public function testGetValuesSelf(): void
    {
        $valueProvider = new ConstExpressionProvider(new Self_(), 'CONST_*', new ReflectionMethod(ClassWithConsts::class, 'setConst'));
        $values = $valueProvider->getValues();

        static::assertValueTypes($values, ['string']);
        static::assertContains('CONST_A', $values);
        static::assertContains('CONST_B', $values);
        static::assertNotContains('CONSTANT_A', $values);
    }

    /**
     * @covers ::getValues
     */
    public function testGetValuesInvalidType(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('ConstExpressionProvider can only be used with object or self typehints');

        $valueProvider = new ConstExpressionProvider(new Callable_([]), 'CONST_*', null);
        $valueProvider->getValues();
    }
}
