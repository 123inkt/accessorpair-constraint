<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;

/**
 * @coversDefaultClass \DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser
 */
class PhpDocParserTest extends TestCase
{
    /**
     * @param string|null $expectedTypehint PHP typehint as string, or null in case of missing phpdoc typehint
     *
     * @dataProvider paramTypehintProvider
     * @covers ::getParamTypehint
     * @covers ::normalizeDocblock
     */
    public function testGetParamTypehint(string $docComment, ?string $expectedTypehint): void
    {
        $parser = new PhpDocParser();
        static::assertSame($expectedTypehint, $parser->getParamTypehint('param', $docComment));
    }

    /**
     * @param string|null $expectedTypehint PHP typehint as string, or null in case of missing phpdoc typehint
     *
     * @dataProvider returnTypehintProvider
     * @covers ::getReturnTypehint
     * @covers ::normalizeDocblock
     */
    public function testGetReturnTypehint(string $docComment, ?string $expectedTypehint): void
    {
        $parser = new PhpDocParser();
        static::assertSame($expectedTypehint, $parser->getReturnTypehint($docComment));
    }

    /**
     * @return Generator<int, array<string|null>>
     */
    public function paramTypehintProvider(): Generator
    {
        // Empty docblock, no param type
        yield ['', null];

        // Missing param variable name
        yield ['/** @param string */', null];

        // Incorrect param variable name
        yield ['/** @param string $incorrect */', null];

        // Simple string typehint, string returned
        yield ['/** @param string $param */', 'string'];

        // Commented string typehint, string returned
        yield ['/** @param string $param Comment about parameter */', 'string'];

        // Simple array typehint, array returned
        yield ['/** @param array $param */', 'array'];

        // Typed array typehint, int[] returned
        yield ['/** @param int[] $param */', 'int[]'];

        // compound typehint with null, ?typehint returned
        yield ['/** @param int|null $param */', '?int'];
        yield ['/** @param null|int $param */', '?int'];
        yield ['/** @param int|null|string $param */', 'int|null|string'];
        yield ['/** @param int|nullo $param */', 'int|nullo'];

        // phpstan/psalm typehints should have a higher priority
        yield ['/** @phpstan-param numeric-string $param @param string $param */', 'numeric-string'];
        yield ['/** @psalm-param numeric-string $param @param string $param */', 'numeric-string'];
    }

    /**
     * @return Generator<int, array<string|null>>
     */
    public function returnTypehintProvider(): Generator
    {
        // Empty docblock, no return type
        yield ['', null];

        // Missing return typehint
        yield ['/** DocComment */ */ */', null];

        // Simple string typehint, string returned
        yield ['/** @return string */', 'string'];

        // Commented string typehint, string returned
        yield ['/** @return string Method returns string */', 'string'];

        // Simple array typehint, array returned
        yield ['/** @return array */', 'array'];

        // Typed array typehint, int[] returned
        yield ['/** @return int[] */', 'int[]'];

        // compound typehint with null, ?typehint returned
        yield ['/** @return int|null */', '?int'];
        yield ['/** @return null|int */', '?int'];
        yield ['/** @return int|null|string */', 'int|null|string'];
        yield ['/** @return int|nullo */', 'int|nullo'];

        // phpstan/psalm typehints should have a higher priority
        yield ['/** @phpstan-return numeric-string @return string */', 'numeric-string'];
        yield ['/** @psalm-return numeric-string @return string */', 'numeric-string'];
    }
}
