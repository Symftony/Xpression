<?php

namespace Symftony\Xpression\Exception\Lexer;

class UnknownTokenTypeException extends LexerException
{
    /**
     * @var string
     */
    private $tokenType;

    /**
     * @param string $tokenType
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($tokenType, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('Unknown token type "%s".', $tokenType), $code, $previous);

        $this->tokenType = $tokenType;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }
}