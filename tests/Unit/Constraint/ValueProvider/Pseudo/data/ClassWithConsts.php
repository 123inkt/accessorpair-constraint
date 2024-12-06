<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\ValueProvider\Pseudo\data;

class ClassWithConsts
{
    public const CONST_A = 'CONST_A';
    public const CONST_B = 'CONST_B';
    public const CONSTANT_A = 'CONSTANT_A';

    /** @var string */
    private string $const;

    /**
     * @param self::CONST_* $const
     */
    public function setConst(string $const): self
    {
        $this->const = $const;

        return $this;
    }

    /**
     * @return self::CONST_*
     */
    public function getConst(): string
    {
        return $this->const;
    }
}
