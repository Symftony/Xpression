<?php

namespace Symftony\Xpression\Exception;

class ExpectedCloseParenthesisException extends SyntaxErrorException
{
    /**
     * @param string $token
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($token, $code = 0, \Exception $previous = null)
    {
        $message = sprintf(
            'Unexpected Expected token "%s", Simple operator token expected : "%s".',
            $token['value'],
            'SIMPLE'
        );

        parent::__construct($token, $message, $code, $previous);
    }
}