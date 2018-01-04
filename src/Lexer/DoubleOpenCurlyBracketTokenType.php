<?php

namespace Symftony\Xpression\Lexer;

class DoubleOpenCurlyBracketTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('{{');
    }
}
