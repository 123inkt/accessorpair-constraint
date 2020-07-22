<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Special;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use Exception;
use RuntimeException;

class ResourceProvider implements ValueProvider
{
    /**
     * @return resource[]
     * @throws Exception
     */
    public function getValues(): array
    {
        $resource = STDOUT;
        if ($resource === false) {
            throw new RuntimeException("Unable to start STDOUT fopen resource"); // @codeCoverageIgnore
        }

        return [$resource];
    }
}
