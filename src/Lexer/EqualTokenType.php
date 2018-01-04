<?php

namespace Symftony\Xpression\Lexer;

class EqualTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('=');
    }
}
