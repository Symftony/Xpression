<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Parser;

class UnsupportedTokenTypeException extends TokenException
{
    /**
     * @param string[] $token
     * @param string[] $supportedTokenTypes
     */
    public function __construct(
        array $token,
        private array $supportedTokenTypes,
        ?string $message = null,
        int $code = 0,
        \Exception $previous = null,
    ) {
        $defaultMessage = sprintf(
            'Unsupported token "%s". Supported was %s.',
            $token['value'],
            implode(', ', $supportedTokenTypes)
        );

        parent::__construct($token, $message ?: $defaultMessage, $code, $previous);
    }

    /**
     * @return string[]
     */
    public function getSupportedTokenTypes(): array
    {
        return $this->supportedTokenTypes;
    }
}
