<?php

namespace Symftony\Xpression\Lexer;

abstract class AbstractTokenType implements TokenTypeInterface
{
    public function getLiteral()
    {
        return implode(' or ', $this->getCatchablePatterns());
    }

    abstract public function getCatchablePatterns();

    public function getNonCatchablePatterns()
    {
        return array();
    }

    public function supportValue(&$value)
    {
        return in_array($value, $this->getCatchablePatterns());
    }
}
