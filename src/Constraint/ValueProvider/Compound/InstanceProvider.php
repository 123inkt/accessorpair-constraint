<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use LogicException;
use PHPUnit\Framework\MockObject\Generator;

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
        $mockGenerator = new Generator();
        $instance      = $mockGenerator->getMock($this->typehint);

        return [$instance];
    }
}
