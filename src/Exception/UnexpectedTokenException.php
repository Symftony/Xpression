<?php

namespace Symftony\Xpression\Exception;

use Symftony\Xpression\Token;

class UnexpectedTokenException extends SyntaxErrorException
{
    /**
     * @var Token
     */
    private $token;

    /**
     * @var string
     */
    private $expectedToken;

    /**
     * @param Token $token
     * @param string $expectedToken
     * @param int $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(Token $token, $expectedToken, $message = null, $code = 0, \Exception $previous = null)
    {
        $defaultMessage = sprintf(
            'Unexpected token "%s". Expected %s.',
            $token->getValue(),
            $expectedToken
        );

        parent::__construct($message ?: $defaultMessage, $code, $previous);

        $this->token = $token;
        $this->expectedToken = $expectedToken;
    }

    /**
     * @return Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getExpectedToken()
    {
        return $this->expectedToken;
    }
}