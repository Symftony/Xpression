<?php

namespace Symftony\Xpression\Exception\Parser;

class UnsupportedTokenTypeException extends TokenException
{
    /**
     * @var string
     */
    private $supportedTokenTypes;

    /**
     * @param array $token
     * @param array $supportedTokenTypes
     * @param int $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(array $token, $supportedTokenTypes, $message = null, $code = 0, \Exception $previous = null)
    {
        $defaultMessage = sprintf(
            'Unsupported token "%s". Supported was %s.',
            $token['value'],
            implode(', ', $supportedTokenTypes)
        );

        parent::__construct($token, $message ?: $defaultMessage, $code, $previous);

        $this->supportedTokenTypes = $supportedTokenTypes;
    }

    /**
     * @return string
     */
    public function getSupportedTokenTypes()
    {
        return $this->supportedTokenTypes;
    }
}
