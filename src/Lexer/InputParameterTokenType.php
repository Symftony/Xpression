<?php

namespace Symftony\Xpression\Lexer;

class InputParameterTokenType extends AbstractTokenType
{
    public function getLiteral()
    {
        return 'string with . _ - and int (str_ing.st-ring2)';
    }

    public function getCatchablePatterns()
    {
        return array('[a-z_][a-z0-9_\.\-]*');
    }

    public function supportValue(&$value)
    {
        return preg_match('/' . implode('|', $this->getCatchablePatterns()) . '/', $value);
    }
}
