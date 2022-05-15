<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\CallableStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ClassStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\HtmlEscapedStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\ListProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LiteralStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\LowercaseStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NonEmptyStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\NumericStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo\TraitStringProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\FloatProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\IntProvider;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Scalar\StringProvider;
use LogicException;
use phpDocumentor\Reflection\PseudoTypes\CallableString;
use phpDocumentor\Reflection\PseudoTypes\HtmlEscapedString;
use phpDocumentor\Reflection\PseudoTypes\IntegerRange;
use phpDocumentor\Reflection\PseudoTypes\List_;
use phpDocumentor\Reflection\PseudoTypes\LiteralString;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;
use phpDocumentor\Reflection\PseudoTypes\NegativeInteger;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyLowercaseString;
use phpDocumentor\Reflection\PseudoTypes\NonEmptyString;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use phpDocumentor\Reflection\PseudoTypes\NumericString;
use phpDocumentor\Reflection\PseudoTypes\PositiveInteger;
use phpDocumentor\Reflection\PseudoTypes\TraitString;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\ArrayKey;
use phpDocumentor\Reflection\Types\ClassString;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PseudoValueProviderFactory
{
    private ValueProviderFactory $valueProviderFactory;

    public function __construct(ValueProviderFactory $valueProviderFactory)
    {
        $this->valueProviderFactory = $valueProviderFactory;
    }

    /**
     * @throws LogicException
     */
    public function getProvider(Type $typehint): ?ValueProvider
    {
        switch (get_class($typehint)) {
            case ArrayKey::class:
                return new ValueProviderList(new StringProvider(), new IntProvider());
            case IntegerRange::class:
                return new IntProvider((int)$typehint->getMinValue(), (int)$typehint->getMaxValue());
            case List_::class:
                return new ListProvider($this->valueProviderFactory->getProvider($typehint->getValueType()));
            case NegativeInteger::class:
                return new IntProvider(PHP_INT_MIN, -1);
            case Numeric_::class:
                return new ValueProviderList(new NumericStringProvider(), new IntProvider(), new FloatProvider(new IntProvider()));
            case PositiveInteger::class:
                return new IntProvider(1, PHP_INT_MAX);
        }

        return $this->getPseudoStringProvider($typehint);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function getPseudoStringProvider(Type $typehint): ?ValueProvider
    {
        switch (get_class($typehint)) {
            case ClassString::class:
                $fqsen = null;
                if ($typehint->getFqsen() !== null) {
                    /** @var class-string|null $fqsen */
                    $fqsen = (string)$typehint->getFqsen();
                }

                return new ClassStringProvider($fqsen);
            case CallableString::class:
                return new CallableStringProvider();
            case HtmlEscapedString::class:
                return new HtmlEscapedStringProvider();
            case LiteralString::class:
                return new LiteralStringProvider();
            case LowercaseString::class:
                return new LowercaseStringProvider(new StringProvider());
            case NonEmptyLowercaseString::class:
                return new NonEmptyStringProvider(new LowercaseStringProvider(new StringProvider()));
            case NonEmptyString::class:
                return new NonEmptyStringProvider(new StringProvider());
            case NumericString::class:
                return new NumericStringProvider();
            case TraitString::class:
                return new TraitStringProvider();
            default:
                return null;
        }
    }
}
