<?php

namespace Symftony\Xpression\Lexer;

class NotEqualTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('≠', '!=');
    }
}
