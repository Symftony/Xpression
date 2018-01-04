<?php

namespace Symftony\Xpression\Lexer;

class DoubleCloseCurlyBracketTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('}}');
    }
}
