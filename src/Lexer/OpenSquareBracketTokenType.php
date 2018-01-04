<?php

namespace Symftony\Xpression\Lexer;

class OpenSquareBracketTokenType extends AbstractTokenType
{
    public function getLiteral()
    {
        return '[';
    }

    public function getCatchablePatterns()
    {
        return array('\[');
    }

    public function supportValue(&$value)
    {
        return '[' === $value;
    }
}
