<?php

declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\fixtures\manual;

class SetterTransformer
{
    public function transform(EmptyClass $data): EmptyClass
    {
        return $data;
    }
}
