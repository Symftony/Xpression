<?php

namespace Symftony\Xpression\Bridge\Doctrine\ORM;

use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Lexer;

class ExprAdapter implements ExpressionBuilderInterface
{
    private Expr $expr;

    public function __construct(Expr $expr)
    {
        $this->expr = $expr;
    }

    public function getSupportedTokenType(): int
    {
        return Lexer::T_ALL - Lexer::T_NOT_AND - Lexer::T_NOT_OR - Lexer::T_XOR;
    }

    public function parameter(mixed $value, bool $isValue = false): mixed
    {
        return $isValue ? $this->expr->literal($value) : $value;
    }

    public function string($value): mixed
    {
        return $this->expr->literal($value);
    }

    public function isNull(string $field)
    {
        return $this->expr->isNull($field);
    }

    public function eq(string $field, mixed $value)
    {
        return $this->expr->eq($field, $value);
    }

    public function neq(string $field, mixed $value)
    {
        return $this->expr->neq($field, $value);
    }

    public function gt(string $field, mixed $value)
    {
        return $this->expr->gt($field, $value);
    }

    public function gte(string $field, mixed $value)
    {
        return $this->expr->gte($field, $value);
    }

    public function lt(string $field, mixed $value)
    {
        return $this->expr->lt($field, $value);
    }

    public function lte(string $field, mixed $value)
    {
        return $this->expr->lte($field, $value);
    }

    public function in($field, array $values)
    {
        return $this->expr->in($field, $values);
    }

    public function notIn($field, array $values)
    {
        return $this->expr->notIn($field, $values);
    }

    public function contains(string $field, mixed $value)
    {
        return $this->expr->like($field, $value);
    }

    public function notContains(string $field, mixed $value)
    {
        return $this->expr->notLike($field, $value);
    }

    public function andX(array $expressions)
    {
        return call_user_func_array([$this->expr, 'andX'], $expressions);
    }

    public function nandX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('nandX');
    }

    public function orX(array $expressions)
    {
        return call_user_func_array([$this->expr, 'orX'], $expressions);
    }

    public function norX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('norX');
    }

    public function xorX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('xorX');
    }
}
