<?php

namespace Symftony\Xpression\Lexer;

class StringTokenType extends AbstractTokenType
{
    public function getLiteral()
    {
        return '\'string\' or "string"';
    }

    public function getCatchablePatterns()
    {
        return array(
            "'(?:[^']|'')*'",
            '"(?:[^"]|"")*"',
        );
    }

    public function supportValue(&$value)
    {
        if ($value[0] === '"') {
            $value = str_replace('""', '"', substr($value, 1, strlen($value) - 2));

            return true;
        }
        if ($value[0] === "'") {
            $value = str_replace("''", "'", substr($value, 1, strlen($value) - 2));

            return true;
        }

        return false;
    }
}
