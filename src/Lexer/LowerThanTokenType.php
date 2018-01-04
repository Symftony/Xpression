<?php

namespace Symftony\Xpression\Lexer;

class LowerThanTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('<');
    }
}
