<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests;

use Generator;
use LogicException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionException;
use SplFileInfo;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @return Generator<string, array<object>>
     * @throws ReflectionException
     */
    public static function getClassDataProvider(string $path, string $namespacePrefix): Generator
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            if (in_array($file->getFilename(), ['.', '..'], true)) {
                continue;
            }

            if (strpos($file->getFilename(), 'Abstract') === 0) {
                continue;
            }

            require_once $file->getPathname();

            $key       = str_replace([$path, '/'], ['', '\\'], $file->getPath()) . '\\' . $file->getBasename('.php');
            $namespace = $namespacePrefix . "\\" . trim($key, '\\');

            if (class_exists($namespace) === false) {
                throw new LogicException("Unable to load class: " . $namespace);
            }

            $reflectionClass = new ReflectionClass($namespace);

            yield $key => [$reflectionClass->newInstanceWithoutConstructor()];
        }
    }
}
