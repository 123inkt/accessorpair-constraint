<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\Typehint;

use DigitalRevolution\AccessorPairConstraint\Constraint\Typehint\PhpDocParser;
use DigitalRevolution\AccessorPairConstraint\Tests\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(PhpDocParser::class)]
class PhpDocParserTest extends TestCase
{
    /**
     * @param string|null $expectedTypehint PHP typehint as string, or null in case of missing phpdoc typehint
     */
    #[DataProvider('paramTypehintProvider')]
    public function testGetParamTypehint(string $docComment, ?string $expectedTypehint): void
    {
        $parser = new PhpDocParser();
        static::assertSame($expectedTypehint, $parser->getParamTypehint('param', $docComment));
    }

    /**
     * @param string|null $expectedTypehint PHP typehint as string, or null in case of missing phpdoc typehint
     */
    #[DataProvider('returnTypehintProvider')]
    public function testGetReturnTypehint(string $docComment, ?string $expectedTypehint): void
    {
        $parser = new PhpDocParser();
        static::assertSame($expectedTypehint, $parser->getReturnTypehint($docComment));
    }

    /**
     * @param array<string, string> $expectedTypehint
     */
    #[DataProvider('templateTypehintProvider')]
    public function testGetTemplateTypehints(string $docComment, array $expectedTypehint): void
    {
        $parser = new PhpDocParser();
        static::assertSame($expectedTypehint, $parser->getTemplateTypehints($docComment));
    }

    /**
     * @return Generator<int, array<string|null>>
     */
    public static function paramTypehintProvider(): Generator
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

        // Typed variable typehint, int returned
        yield ['/** @param int ...$param */', 'int'];

        // compound typehint with null, ?typehint returned
        yield ['/** @param int|null $param */', '?int'];
        yield ['/** @param null|int $param */', '?int'];
        yield ['/** @param int|null|string $param */', 'int|null|string'];
        yield ['/** @param int|nullo $param */', 'int|nullo'];

        // phpstan/psalm typehints should have a higher priority
        yield ['/** @phpstan-param numeric-string $param @param string $param */', 'numeric-string'];
        yield ['/** @psalm-param numeric-string $param @param string $param */', 'numeric-string'];

        // Lenient with spaces
        yield ['/** @param array$param */', 'array'];
        yield ['/**@param array$param*/', 'array'];
        yield ["/**\n     *@param array\$param\n     */", 'array'];

        // Don't match parameters where the name is a substring of another parameter
        yield ['/** @param string $paramList */', null];
    }

    /**
     * @return Generator<int, array<string|null>>
     */
    public static function returnTypehintProvider(): Generator
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

        // Missing spaces
        yield ['/** @return array */', 'array'];
        yield ['/**@return array*/', 'array'];
        yield ["/**\n     *@return array\n     */", 'array'];

        // Constant expressions
        yield ['/** @return self::CONSTANT_* */', 'self::CONSTANT_*'];
        yield ['/** @return SomeClass::CONSTANT_* */', 'SomeClass::CONSTANT_*'];
    }

    /**
     * @return Generator<int, array{0: string, 1: array<string, string>}>
     */
    public static function templateTypehintProvider(): Generator
    {
        // Empty docblock, no return type
        yield ['', []];

        // Missing return typehint
        yield ['/** DocComment */ */ */', []];

        // Simple string typehint, string returned
        yield ['/** @template T of string */', ['T' => 'string']];

        // Typed array typehint, int[] returned
        yield ['/** @template T of int[] */', ['T' => 'int[]']];

        // Multiple templates
        yield ['/** @template T of int[] * @template K of string */', ['T' => 'int[]', 'K' => 'string']];
    }
}
