<?php

namespace Symftony\Xpression\Lexer;

class GreaterThanEqualTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('≥', '>=');
    }
}
