<?php

namespace Symftony\Xpression\Lexer;

class IntegerTokenType extends AbstractTokenType
{
    public function getLiteral()
    {
        return 'all integer (1 / -2 / 03 / 0x1A / Ob101)';
    }

    public function getCatchablePatterns()
    {
        return array('(?:[+-]?0b[01]+|0[xX][0-9a-fA-F]+|0[0-7]+|[1-9][0-9]*|0)');
    }

    public function supportValue(&$value)
    {
        if (is_numeric($value) && strpos($value, '.') === false) {
            $value = (int)$value;

            return true;
        }

        return false;
    }
}
