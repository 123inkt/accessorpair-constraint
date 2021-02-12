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

        preg_match('/\*\s+@param\s+(.*?)\s+(?:\.\.\.)?' . preg_quote('$' . $parameterName, '/') . '/i', $docComment, $matches);
        if (isset($matches[1]) === false) {
            return null;
        }

        return $this->normalizeDocblock((string)$matches[1]);
    }

    /**
     * Get the return typehint from the PHPDoc comment
     */
    public function getReturnTypehint(string $originalDocComment): ?string
    {
        $docComment = trim($originalDocComment);
        // empty docblock provided, no typehint found
        if ($docComment === '') {
            return null;
        }

        $docComment = preg_replace('/array<(.*?),\s(.*?)>/', 'array<$1,$2>', $docComment);
        if ($docComment === null) {
            return null;
        }

        preg_match('/\*\s+@return\s+(.*?)\s+(?:\.\.\.)?/', $docComment, $matches);
        if (isset($matches[1]) === false) {
            return null;
        }

        return $this->normalizeDocblock((string)$matches[1]);
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
        if ($newTypehint === null) {
            return $typehint;
        }

        if ($count === 0) {
            return $typehint;
        }

        return "?" . $newTypehint;
    }
}
