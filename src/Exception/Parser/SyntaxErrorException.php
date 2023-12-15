<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Parser;

class SyntaxErrorException extends ParserException
{
    public function __construct(
        ?string $message = null,
        int $code = 0,
        \Exception $previous = null,
    ) {
        parent::__construct($message ?: 'Syntax error.', $code, $previous);
    }
}
