<?php

namespace Symftony\Xpression\Lexer;

class NotAndTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('!&');
    }
}
