<?php

namespace Symftony\Xpression\Lexer;

interface TokenTypeInterface
{
    public function getLiteral();

    public function getCatchablePatterns();

    public function getNonCatchablePatterns();

    public function supportValue(&$value);
}
