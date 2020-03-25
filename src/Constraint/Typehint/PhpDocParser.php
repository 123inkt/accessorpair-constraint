<?php

namespace DigitalRevolution\AccessorPairConstraint\Constraint\Typehint;

class PhpDocParser
{
    /**
     * Get the parameter typehint from the PHPDoc comment
     *
     * @return string|null PHP typehint as string, or null in case of missing phpdoc typehint
     */
    public function getParamTypehint(string $parameterName, string $docComment)
    {
        // empty docblock provided, no typehint found
        if (trim($docComment) === '') {
            return null;
        }

        preg_match('/\*\s+@param\s+(.*?)\s+(?:\.\.\.)?' . preg_quote('$' . $parameterName, '/') . '/i', $docComment, $matches);
        if (isset($matches[1]) === false) {
            return null;
        }

        return (string)$matches[1];
    }

    /**
     * Get the return typehint from the PHPDoc comment
     *
     * @return string|null
     */
    public function getReturnTypehint(string $docComment)
    {
        // empty docblock provided, no typehint found
        if (trim($docComment) === '') {
            return null;
        }

        preg_match('/\*\s+@return\s+(.*?)\s+(?:\.\.\.)?/', $docComment, $matches);
        if (isset($matches[1]) === false) {
            return null;
        }

        return (string)$matches[1];
    }
}
