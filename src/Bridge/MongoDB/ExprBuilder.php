<?php

declare(strict_types=1);

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

    public function string(mixed $value): mixed
    {
        return $value;
    }

    public function isNull(string $field): mixed
    {
        return [$field => null];
    }

    public function eq(string $field, mixed $value): mixed
    {
        return [$field => ['$eq' => $value]];
    }

    public function neq(string $field, mixed $value): mixed
    {
        return [$field => ['$ne' => $value]];
    }

    public function gt(string $field, mixed $value): mixed
    {
        return [$field => ['$gt' => $value]];
    }

    public function gte(string $field, mixed $value): mixed
    {
        return [$field => ['$gte' => $value]];
    }

    public function lt(string $field, mixed $value): mixed
    {
        return [$field => ['$lt' => $value]];
    }

    public function lte(string $field, mixed $value): mixed
    {
        return [$field => ['$lte' => $value]];
    }

    public function in(string $field, array $values): mixed
    {
        return [$field => ['$in' => $values]];
    }

    public function notIn(string $field, array $values): mixed
    {
        return [$field => ['$nin' => $values]];
    }

    public function contains(string $field, mixed $value): mixed
    {
        return [$field => ['$regex' => $value]];
    }

    public function notContains(string $field, mixed $value): mixed
    {
        return ['$not' => $this->contains($field, $value)];
    }

    public function andX(array $expressions): mixed
    {
        return ['$and' => $expressions];
    }

    // Not A AND B = Not A OR Not B
    public function nandX(array $expressions): mixed
    {
        return $this->orX(array_map(static fn ($expression) => ['$not' => $expression], $expressions));
    }

    public function orX(array $expressions): mixed
    {
        return ['$or' => $expressions];
    }

    public function norX(array $expressions): mixed
    {
        return ['$nor' => $expressions];
    }

    public function xorX(array $expressions): mixed
    {
        throw new UnsupportedExpressionTypeException('xorX');
    }
}
