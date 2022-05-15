<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Pseudo;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;

class HtmlEscapedStringProvider implements ValueProvider
{
    /**
     * @return html-escaped-string[]
     */
    public function getValues(): array
    {
        return array_map('htmlspecialchars', ['<strong>foo</strong>', '<em>bar</em>']);
    }
}
