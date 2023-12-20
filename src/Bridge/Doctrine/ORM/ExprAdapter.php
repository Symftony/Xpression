<?php

declare(strict_types=1);

namespace Symftony\Xpression\Bridge\Doctrine\ORM;

use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
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

    public function string(mixed $value): mixed
    {
        return $this->expr->literal($value);
    }

    public function isNull(string $field): mixed
    {
        return $this->expr->isNull($field);
    }

    public function eq(string $field, mixed $value): mixed
    {
        return $this->expr->eq($field, $value);
    }

    public function neq(string $field, mixed $value): mixed
    {
        return $this->expr->neq($field, $value);
    }

    public function gt(string $field, mixed $value): mixed
    {
        return $this->expr->gt($field, $value);
    }

    public function gte(string $field, mixed $value): mixed
    {
        return $this->expr->gte($field, $value);
    }

    public function lt(string $field, mixed $value): mixed
    {
        return $this->expr->lt($field, $value);
    }

    public function lte(string $field, mixed $value): mixed
    {
        return $this->expr->lte($field, $value);
    }

    public function in(string $field, array $values): mixed
    {
        return $this->expr->in($field, $values);
    }

    public function notIn(string $field, array $values): mixed
    {
        return $this->expr->notIn($field, $values);
    }

    public function contains(string $field, mixed $value): mixed
    {
        return $this->expr->like($field, $value);
    }

    public function notContains(string $field, mixed $value): mixed
    {
        return $this->expr->notLike($field, $value);
    }

    public function andX(array $expressions): mixed
    {
        return $this->expr->andX(...$expressions);
    }

    public function nandX(array $expressions): mixed
    {
        throw new UnsupportedExpressionTypeException('nandX');
    }

    public function orX(array $expressions): mixed
    {
        return $this->expr->orX(...$expressions);
    }

    public function norX(array $expressions): mixed
    {
        throw new UnsupportedExpressionTypeException('norX');
    }

    public function xorX(array $expressions): mixed
    {
        throw new UnsupportedExpressionTypeException('xorX');
    }
}
