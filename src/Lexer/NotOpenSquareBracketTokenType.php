<?php

namespace Symftony\Xpression\Lexer;

class NotOpenSquareBracketTokenType extends AbstractTokenType
{
    public function getLiteral()
    {
        return '![';
    }

    public function getCatchablePatterns()
    {
        return array('!\[');
    }

    public function supportValue(&$value)
    {
        return '![' === $value;
    }
}
