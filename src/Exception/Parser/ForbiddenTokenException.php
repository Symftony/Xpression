<?php

namespace Symftony\Xpression\Exception\Parser;

class ForbiddenTokenException extends SyntaxErrorException
{
    /**
     * @var array
     */
    private $token;

    /**
     * @var string
     */
    private $expectedTokenTypes;

    /**
     * @param array $token
     * @param array $expectedTokenTypes
     * @param int $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(array $token, $expectedTokenTypes, $message = null, $code = 0, \Exception $previous = null)
    {
        $defaultMessage = sprintf(
            'Forbidden token "%s". Expected %s.',
            $token['value'],
            implode(', ', $expectedTokenTypes)
        );

        parent::__construct($message ?: $defaultMessage, $code, $previous);

        $this->token = $token;
        $this->expectedTokenTypes = $expectedTokenTypes;
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
    public function getExpectedTokenTypes()
    {
        return $this->expectedTokenTypes;
    }
}