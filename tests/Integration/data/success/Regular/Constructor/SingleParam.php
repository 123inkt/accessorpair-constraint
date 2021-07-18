<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Constructor;

class SingleParam
{
    /** @var string */
    private $param;

    public function __construct(string $param)
    {
        $this->param = $param;
    }

    public function getParam(): string
    {
        return $this->param;
    }
}
