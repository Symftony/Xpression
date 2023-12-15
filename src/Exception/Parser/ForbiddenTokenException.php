<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Parser;

class ForbiddenTokenException extends TokenException
{
    /**
     * @param string[] $token
     * @param string[] $allowedTokenTypes
     */
    public function __construct(
        array $token,
        private array $allowedTokenTypes,
        ?string $message = null,
        int $code = 0,
        \Exception $previous = null,
    ) {
        $defaultMessage = sprintf(
            'Forbidden token "%s". Allowed was %s.',
            $token['value'],
            implode(', ', $allowedTokenTypes)
        );

        parent::__construct($token, $message ?: $defaultMessage, $code, $previous);
    }

    /**
     * @return string[]
     */
    public function getAllowedTokenTypes(): array
    {
        return $this->allowedTokenTypes;
    }
}
