<?php

namespace Symftony\Xpression\Lexer;

class XorTokenType extends AbstractTokenType
{
    public function getLiteral()
    {
        return '⊕ or ^|';
    }

    public function getCatchablePatterns()
    {
        return array('⊕', '\^\|');
    }

    public function supportValue(&$value)
    {
        if (in_array($value, array('⊕', '^|'))) {
            $value = '⊕';

            return true;
        }

        return false;
    }
}
