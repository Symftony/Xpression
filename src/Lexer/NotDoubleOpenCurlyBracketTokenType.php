<?php

namespace Symftony\Xpression\Lexer;

class NotDoubleOpenCurlyBracketTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('!{{');
    }
}
