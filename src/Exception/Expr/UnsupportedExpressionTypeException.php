<?php

namespace Symftony\Xpression\Exception\Expr;

class UnsupportedExpressionTypeException extends \LogicException
{
    /**
     * @var string
     */
    private $expressionType;

    /**
     * @param string $expressionType
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($expressionType, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('Unsupported expression type "%s".', $expressionType), $code, $previous);
        $this->expressionType = $expressionType;
    }

    /**
     * @return string
     */
    public function getExpressionType()
    {
        return $this->expressionType;
    }
}
