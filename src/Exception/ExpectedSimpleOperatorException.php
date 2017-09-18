<?php

namespace Symftony\Xpression\Exception;

class ExpectedSimpleOperatorException extends UnexpectedTokenException
{
    /**
     * @param array $token
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($token, $code = 0, \Exception $previous = null)
    {
        $message = sprintf(
            'Unexpected token "%s", Simple operator token expected : "%s".',
            $token['value'],
            'TODO'
        );

        parent::__construct($token, 'TODO', $message, $code, $previous);
    }
}