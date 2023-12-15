<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Parser;

class TokenException extends SyntaxErrorException
{
    /**
     * @param string[] $token
     */
    public function __construct(
        private array $token,
        ?string $message = null,
        int $code = 0,
        \Exception $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string[]
     */
    public function getToken(): array
    {
        return $this->token;
    }
}
