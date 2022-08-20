<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\MockObject\Generator;

class IntersectionProvider implements ValueProvider
{
    /** @var Type[] */
    private array $typehints;

    private static $createdClasses = [];

    /**
     * @param Type[] $typehints
     */
    public function __construct(array $typehints)
    {
        $this->typehints = $typehints;
    }

    public function getValues(): array
    {
        $interfaces = [];
        $extends    = null;
        foreach ($this->typehints as $typehint) {
            $fqnsen = (string)$typehint;
            if (interface_exists($fqnsen)) {
                $interfaces[] = $fqnsen;
            } elseif (class_exists($fqnsen)) {
                $extends = $fqnsen;
            }
        }

        $class = '';
        if ($extends !== null) {
            $class .= " extends " . $extends;
        }
        if (count($interfaces)) {
            $class .= " implements " . implode(',', $interfaces) . "{}";
        }

        $className = "AccesorPairConstraintIntersectionClass" . md5($class);
        if (isset(self::$createdClasses[$className]) === false) {
            $class = "abstract class " . $className . " " . $class;
            eval($class);

            self::$createdClasses[$className] = true;
        }

        $mockGenerator = new Generator();
        $instance      = $mockGenerator->getMockForAbstractClass($className, [], '', false, false);

        return [$instance];
    }
}
