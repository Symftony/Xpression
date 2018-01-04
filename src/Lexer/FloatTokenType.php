<?php

namespace Symftony\Xpression\Lexer;

class FloatTokenType extends AbstractTokenType
{
    public function getLiteral()
    {
        return 'all float (.5 / 1.5 / -1.2e3)';
    }

    public function getCatchablePatterns()
    {
        return array('(?:[+-]?(?:(?:(?:[0-9]+|(?:[0-9]*[\.][0-9]+)|(?:[0-9]+[\.][0-9]*))[eE][+-]?[0-9]+)|(?:[0-9]*[\.][0-9]+)|(?:[0-9]+[\.][0-9]*)))');
    }

    public function supportValue(&$value)
    {
        if (is_numeric($value) && strpos($value, '.') !== false) {
            $value = (float)$value;

            return true;
        }

        return false;
    }
}
