<?php

namespace Symftony\Xpression\Exception\Parser;

class SyntaxErrorException extends ParserException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message ?: 'Syntax error.', $code, $previous);
    }
}