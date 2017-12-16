<?php

namespace Symftony\Xpression\Exception\Parser;

class TokenException extends SyntaxErrorException
{
    /**
     * @var array
     */
    private $token;

    /**
     * @param array $token
     * @param int $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(array $token, $message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->token = $token;
    }

    /**
     * @return array
     */
    public function getToken()
    {
        return $this->token;
    }
}
