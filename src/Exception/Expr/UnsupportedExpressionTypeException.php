<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Expr;

class UnsupportedExpressionTypeException extends \LogicException
{
    public function __construct(
        private string $expressionType,
        int $code = 0,
        \Exception $previous = null,
    ) {
        parent::__construct(sprintf('Unsupported expression type "%s".', $expressionType), $code, $previous);
    }

    public function getExpressionType(): string
    {
        return $this->expressionType;
    }
}
