<?php

namespace Symftony\Xpression\Lexer;

class CommaTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array(',');
    }
}
