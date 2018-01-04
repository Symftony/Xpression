<?php

namespace Symftony\Xpression\Lexer;

class AndTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('&');
    }
}
