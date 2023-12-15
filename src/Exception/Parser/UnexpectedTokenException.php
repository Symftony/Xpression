<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Parser;

class UnexpectedTokenException extends TokenException
{
    /**
     * @param string[] $token
     * @param string[] $expectedTokenTypes
     */
    public function __construct(
        array $token,
        private array $expectedTokenTypes,
        ?string $message = null,
        int $code = 0,
        \Exception $previous = null,
    ) {
        $defaultMessage = sprintf(
            'Unexpected token "%s". Expected was %s.',
            $token['value'],
            implode(', ', $expectedTokenTypes)
        );

        parent::__construct($token, $message ?: $defaultMessage, $code, $previous);
    }

    /**
     * @return string[]
     */
    public function getExpectedTokenTypes(): array
    {
        return $this->expectedTokenTypes;
    }
}
