<?php

namespace Symftony\Xpression\Exception;

class ExpressionNotSupportedException extends \Exception
{
    /**
     * @param string $expressionType
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($expressionType, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('Expression "%s" is not supported.', $expressionType), $code, $previous);
    }
}