<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Lexer;

class UnknownTokenTypeException extends LexerException
{
    public function __construct(
        private string $tokenType,
        int $code = 0,
        \Exception $previous = null,
    ) {
        parent::__construct(sprintf('Unknown token type "%s".', $tokenType), $code, $previous);
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }
}
