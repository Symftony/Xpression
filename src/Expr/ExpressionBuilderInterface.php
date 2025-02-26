<?php

declare(strict_types=1);

namespace Symftony\Xpression\Expr;

interface ExpressionBuilderInterface
{
    /**
     * Must return all supported token type.
     */
    public function getSupportedTokenType(): int;

    public function parameter(mixed $value, bool $isValue = false): mixed;

    public function string(mixed $value): mixed;

    public function isNull(string $field): mixed;

    public function eq(string $field, mixed $value): mixed;

    public function neq(string $field, mixed $value): mixed;

    public function gt(string $field, mixed $value): mixed;

    public function gte(string $field, mixed $value): mixed;

    public function lt(string $field, mixed $value): mixed;

    public function lte(string $field, mixed $value): mixed;

    public function in(string $field, array $values): mixed;

    public function notIn(string $field, array $values): mixed;

    public function contains(string $field, mixed $value): mixed;

    public function notContains(string $field, mixed $value): mixed;

    public function andX(array $expressions): mixed;

    public function nandX(array $expressions): mixed;

    public function orX(array $expressions): mixed;

    public function norX(array $expressions): mixed;

    public function xorX(array $expressions): mixed;
}
