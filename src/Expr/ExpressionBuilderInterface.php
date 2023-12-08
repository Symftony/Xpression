<?php

namespace Symftony\Xpression\Expr;

use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\Expr\Expression;

interface ExpressionBuilderInterface
{
    /**
     * Must return all supported token type
     */
    public function getSupportedTokenType(): int;

    public function parameter(mixed $value, bool $isValue = false): mixed;

    public function string($value): mixed;

    public function isNull(string $field);

    public function eq(string $field, mixed $value);

    public function neq(string $field, mixed $value);

    public function gt(string $field, mixed $value);

    public function gte(string $field, mixed $value);

    public function lt(string $field, mixed $value);

    public function lte(string $field, mixed $value);

    public function in(string $field, array $values);

    public function notIn(string $field, array $values);

    public function contains(string $field, mixed $value);

    public function notContains(string $field, mixed $value);

    public function andX(array $expressions);

    public function nandX(array $expressions);

    public function orX(array $expressions);

    public function norX(array $expressions);

    public function xorX(array $expressions);
}
