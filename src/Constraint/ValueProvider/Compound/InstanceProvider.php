<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use LogicException;
use PHPUnit\Framework\MockObject\Generator\Generator;
use PHPUnit\Runner\Version;
use UnitEnum;

class InstanceProvider implements ValueProvider
{
    /** @var class-string */
    protected $typehint;

    /**
     * @param class-string $typehint
     */
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
        if (enum_exists($this->typehint)) {
            /** @var class-string<UnitEnum> $enum */
            $enum = $this->typehint;

            return $enum::cases();
        }

        // It's not allowed to make mocks of the DateTimeInterface class itself
        if ($this->typehint === DateTimeInterface::class) {
            return [$this->getMockObject(DateTime::class), $this->getMockObject(DateTimeImmutable::class)];
        }

        return [$this->getMockObject($this->typehint)];
    }

    private function getMockObject(string $typehint): object
    {
        if (class_exists('PHPUnit\Framework\MockObject\Generator\Generator')) {
            $mockGenerator = new Generator();
            if (method_exists($mockGenerator, 'testDouble')) {
                if (method_exists(Version::class, 'majorVersionNumber')) {
                    if (Version::majorVersionNumber() === 11) {
                        $instance = $mockGenerator->testDouble($typehint, true, true, [], [], '', false);
                    } else {
                        $instance = $mockGenerator->testDouble($typehint, true, [], [], '', false);
                    }
                } else {
                    $instance = $mockGenerator->testDouble($typehint, true, [], [], '', false);
                }
            } else {
                $instance = $mockGenerator->getMock($typehint, [], [], '', false);
            }
        } else {
            $mockGenerator = new \PHPUnit\Framework\MockObject\Generator();
            $instance      = $mockGenerator->getMock($typehint, [], [], '', false);
        }

        return $instance;
    }
}
