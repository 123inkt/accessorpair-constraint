<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint;

class PhpDocParser
{
    /**
     * Get the parameter typehint from the PHPDoc comment
     *
     * @return string|null PHP typehint as string, or null in case of missing phpdoc typehint
     */
    public function getParamTypehint(string $parameterName, string $docComment): ?string
    {
        // empty docblock provided, no typehint found
        if (trim($docComment) === '') {
            return null;
        }

        preg_match('/\*\s*@(?:phpstan|psalm)-param\s+(.*?)\s*(?:\.\.\.)?' . preg_quote('$' . $parameterName, '/') . '\W/i', $docComment, $matches);
        if (isset($matches[1])) {
            return $this->normalizeDocblock($matches[1]);
        }

        preg_match('/\*\s*@param\s+(.*?)\s*(?:\.\.\.)?' . preg_quote('$' . $parameterName, '/') . '\W/i', $docComment, $matches);
        if (isset($matches[1])) {
            return $this->normalizeDocblock($matches[1]);
        }

        return null;
    }

    /**
     * Get the return typehint from the PHPDoc comment
     */
    public function getReturnTypehint(string $originalDocComment): ?string
    {
        $docComment = trim($originalDocComment);
        $docComment = str_replace([', ', ': '], [',', ':'], $docComment);
        // empty docblock provided, no typehint found
        if ($docComment === '') {
            return null;
        }

        // Convert array<int, string> to array<int,string>
        $docComment = preg_replace('/(\w+)<(.*?),\s(.*?)>/', '$1<$2,$3>', $docComment);
        if ($docComment === null) {
            return null; // @codeCoverageIgnore
        }

        preg_match('/\*\s*@(?:phpstan|psalm)-return\s+(.*?)(?:\s+|\*)/', $docComment, $matches);
        if (isset($matches[1])) {
            return $this->normalizeDocblock($matches[1]);
        }

        preg_match('/\*\s*@return\s+(.*?)(?:\s+|\*)/', $docComment, $matches);
        if (isset($matches[1])) {
            return $this->normalizeDocblock($matches[1]);
        }

        return null;
    }

    /**
     * Get the type templates from the PHPDoc comment
     *
     * @return array<string, string>
     */
    public function getTemplateTypehints(string $originalDocComment): array
    {
        $docComment = trim($originalDocComment);
        // empty docblock provided, no typehint found
        if ($docComment === '') {
            return [];
        }

        preg_match_all('/\*\s*@template\s+(.*?)\sof\s(.*?)(?:\s+|\*)/', $docComment, $matches);

        return array_combine($matches[1], $matches[2]);
    }

    /**
     * Normalize docblock typehints to match PHPs typehints
     * For example: turns string|null into ?string
     */
    private function normalizeDocblock(string $typehint): string
    {
        if (substr_count($typehint, "|") !== 1 || strpos($typehint, "null") === false) {
            return $typehint;
        }

        $newTypehint = preg_replace('/(^null\||\|null$)/', '', $typehint, -1, $count);
        if ($newTypehint === null || $count === 0) {
            return $typehint;
        }

        return "?" . $newTypehint;
    }
}
