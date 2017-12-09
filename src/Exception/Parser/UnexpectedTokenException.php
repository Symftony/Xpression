<?php

namespace Symftony\Xpression\Exception\Parser;

class UnexpectedTokenException extends TokenException
{
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
            'Unexpected token "%s". Expected was %s.',
            $token['value'],
            implode(', ', $expectedTokenTypes)
        );

        parent::__construct($token, $message ?: $defaultMessage, $code, $previous);

        $this->expectedTokenTypes = $expectedTokenTypes;
    }

    /**
     * @return string
     */
    public function getExpectedTokenTypes()
    {
        return $this->expectedTokenTypes;
    }
}