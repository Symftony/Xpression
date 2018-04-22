<?php

namespace Symftony\Xpression\Lexer;

class GreaterThanEqualTokenType extends AbstractTokenType
{
    public function getCatchablePatterns()
    {
        return array('≥', '>=');
    }

    public function supportValue(&$value)
    {
        if (in_array($value, $this->getCatchablePatterns())) {
            $value = '≥';

            return true;
        }

        return false;
    }
}
