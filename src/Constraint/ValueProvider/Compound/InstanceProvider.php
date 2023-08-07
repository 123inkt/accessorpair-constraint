<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use LogicException;
use PHPUnit\Framework\MockObject\Generator\Generator;
use UnitEnum;

class InstanceProvider implements ValueProvider
{
    /** @var string */
    protected $typehint;

    public function __construct(string $typehint)
    {
        $this->typehint = ltrim($typehint, '\\');

        if (class_exists($typehint) === false && interface_exists($typehint) === false) {
            throw new LogicException("Unknown class/interface typehint found: " . $typehint);
        }
    }

    /**
     * @inheritDoc
     */
    public function getValues(): array
    {
        if (PHP_VERSION_ID >= 80100 && enum_exists($this->typehint)) {
            /** @var UnitEnum $enum */
            $enum = $this->typehint;

            return $enum::cases();
        }

        if (class_exists('PHPUnit\Framework\MockObject\Generator\Generator')) {
            /** @var \PHPUnit\Framework\MockObject\Generator $mockGenerator */
            $mockGenerator = new Generator();
        } else {
            $mockGenerator = new \PHPUnit\Framework\MockObject\Generator();
        }
        $instance = $mockGenerator->getMock($this->typehint, [], [], '', false);

        return [$instance];
    }
}
