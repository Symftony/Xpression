<?php

namespace Symftony\Xpression\Lexer;

class GreaterThanTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('>');
    }
}
