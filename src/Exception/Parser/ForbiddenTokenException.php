<?php

namespace Symftony\Xpression\Exception\Parser;

class ForbiddenTokenException extends TokenException
{
    /**
     * @var string
     */
    private $allowedTokenTypes;

    /**
     * @param array $token
     * @param array $allowedTokenTypes
     * @param int $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(array $token, $allowedTokenTypes, $message = null, $code = 0, \Exception $previous = null)
    {
        $defaultMessage = sprintf(
            'Forbidden token "%s". Allowed was %s.',
            $token['value'],
            implode(', ', $allowedTokenTypes)
        );

        parent::__construct($token, $message ?: $defaultMessage, $code, $previous);

        $this->allowedTokenTypes = $allowedTokenTypes;
    }

    /**
     * @return string
     */
    public function getAllowedTokenTypes()
    {
        return $this->allowedTokenTypes;
    }
}