<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests;

use Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use SplFileInfo;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function getClassDataProvider(string $path, string $namespacePrefix): Generator
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            if (in_array($file->getFilename(), ['.', '..'], true)) {
                continue;
            }

            require_once $file->getPathname();

            $key       = str_replace([$path, '/'], ['', '\\'], $file->getPath()) . '\\' . $file->getBasename('.php');
            $namespace = $namespacePrefix . "\\" . trim($key, '\\');

            $reflectionClass = new ReflectionClass($namespace);

            yield $key => [$reflectionClass->newInstanceWithoutConstructor()];
        }
    }
}
