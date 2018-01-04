<?php

namespace Symftony\Xpression\Lexer;

class LowerThanEqualTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('≤', '<=');
    }
}
