<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular;

class MultiPropertySameName
{
    /** @var string[] */
    private array $data;

    public function __construct(string $data)
    {
        $this->addData($data);
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string[] $data
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function addData(string $data): self
    {
        $this->data[] = $data;

        return $this;
    }
}
