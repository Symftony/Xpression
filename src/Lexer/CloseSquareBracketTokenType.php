<?php

namespace Symftony\Xpression\Lexer;

class CloseSquareBracketTokenType extends AbstractTokenType
{
    public function getLiteral()
    {
        return ']';
    }

    public function getCatchablePatterns()
    {
        return array('\]');
    }

    public function supportValue(&$value)
    {
        return ']' === $value;
    }
}
