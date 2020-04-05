<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Constructor;

class MultiParam
{
    /** @var string */
    private $first;

    /** @var bool */
    private $second;

    public function __construct(string $first, bool $second)
    {
        $this->first  = $first;
        $this->second = $second;
    }

    /**
     * @return string
     */
    public function getFirst(): string
    {
        return $this->first;
    }

    /**
     * @return bool
     */
    public function isSecond(): bool
    {
        return $this->second;
    }
}
