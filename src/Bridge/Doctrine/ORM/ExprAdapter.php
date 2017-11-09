<?php

namespace Symftony\Xpression\Bridge\Doctrine\ORM;

use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Lexer;

class ExprAdapter implements ExpressionBuilderInterface
{
    /**
     * @var Expr
     */
    private $expr;

    /**
     * @param Expr $expr
     */
    public function __construct(Expr $expr)
    {
        $this->expr = $expr;
    }

    /**
     * @return int
     */
    public function getSupportedTokenType()
    {
        return Lexer::T_ALL - Lexer::T_NOT_AND - Lexer::T_NOT_OR - Lexer::T_XOR;
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function isNull($field)
    {
        return $this->expr->isNull($field);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Expr\Comparison
     */
    public function eq($field, $value)
    {
        return $this->expr->eq($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Expr\Comparison
     */
    public function neq($field, $value)
    {
        return $this->expr->neq($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Expr\Comparison
     */
    public function gt($field, $value)
    {
        return $this->expr->gt($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Expr\Comparison
     */
    public function gte($field, $value)
    {
        return $this->expr->gte($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Expr\Comparison
     */
    public function lt($field, $value)
    {
        return $this->expr->lt($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Expr\Comparison
     */
    public function lte($field, $value)
    {
        return $this->expr->lte($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return Expr\Func
     */
    public function in($field, array $values)
    {
        return $this->expr->in($field, $values);
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return Expr\Func
     */
    public function notIn($field, array $values)
    {
        return $this->expr->notIn($field, $values);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Expr\Comparison
     */
    public function contains($field, $value)
    {
        return $this->expr->like($field, $value);
    }

    /**
     * @param array $expressions
     *
     * @return Expr\Andx
     */
    public function andX(array $expressions)
    {
        return call_user_func_array(array($this->expr, 'andX'), $expressions);
    }

    /**
     * @param array $expressions
     */
    public function nandX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('nandX');
    }

    /**
     * @param array $expressions
     *
     * @return Expr\Orx
     */
    public function orX(array $expressions)
    {
        return call_user_func_array(array($this->expr, 'orX'), $expressions);
    }

    /**
     * @param array $expressions
     */
    public function norX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('norX');
    }

    /**
     * @param array $expressions
     */
    public function xorX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('xorX');
    }
}
