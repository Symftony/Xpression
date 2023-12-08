<?php

namespace Symftony\Xpression\Bridge\MongoDB;

use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Lexer;

class ExprBuilder implements ExpressionBuilderInterface
{
    public function getSupportedTokenType(): int
    {
        return Lexer::T_ALL - Lexer::T_XOR;
    }

    public function parameter(mixed $value, bool $isValue = false): mixed
    {
        return $value;
    }

    public function string($value): mixed
    {
        return $value;
    }

    public function isNull(string $field)
    {
        return [$field => null];
    }

    public function eq(string $field, mixed $value)
    {
        return [$field => ['$eq' => $value]];
    }

    public function neq(string $field, mixed $value)
    {
        return [$field => ['$ne' => $value]];
    }

    public function gt(string $field, mixed $value)
    {
        return [$field => ['$gt' => $value]];
    }

    public function gte(string $field, mixed $value)
    {
        return [$field => ['$gte' => $value]];
    }

    public function lt(string $field, mixed $value)
    {
        return [$field => ['$lt' => $value]];
    }

    public function lte(string $field, mixed $value)
    {
        return [$field => ['$lte' => $value]];
    }

    public function in($field, array $values)
    {
        return [$field => ['$in' => $values]];
    }

    public function notIn($field, array $values)
    {
        return [$field => ['$nin' => $values]];
    }

    public function contains(string $field, mixed $value)
    {
        return [$field => ['$regex' => $value]];
    }

    public function notContains(string $field, mixed $value)
    {
        return ['$not' => $this->contains($field, $value)];
    }

    public function andX(array $expressions)
    {
        return ['$and' => $expressions];
    }

    // Not A AND B = Not A OR Not B
    public function nandX(array $expressions)
    {
        return $this->orX(array_map(function ($expression) {
            return ['$not' => $expression];
        }, $expressions));
    }

    public function orX(array $expressions)
    {
        return ['$or' => $expressions];
    }

    public function norX(array $expressions)
    {
        return ['$nor' => $expressions];
    }

    public function xorX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('xorX');
    }
}
