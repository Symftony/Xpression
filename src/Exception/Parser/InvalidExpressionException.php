<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Parser;

class InvalidExpressionException extends \RuntimeException
{
    public function __construct(
        private string $input,
        string $message = '',
        int $code = 0,
        \Exception $previous = null,
    ) {
        parent::__construct('' !== $message ? $message : 'Invalid expression.', $code, $previous);
    }

    public function getInput(): string
    {
        return $this->input;
    }
}
