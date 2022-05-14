<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use stdClass;

class ClassStringProvider implements ValueProvider
{
    /** @var class-string|null */
    private ?string $fqsen;

    /**
     * @param class-string|null $fqsen
     */
    public function __construct(?string $fqsen = null)
    {
        $this->fqsen = $fqsen;
    }

    /**
     * @return class-string[]
     */
    public function getValues(): array
    {
        if ($this->fqsen !== null) {
            return [$this->fqsen];
        }

        return [stdClass::class, self::class];
    }
}
