<?php

declare(strict_types=1);

namespace Symftony\Xpression\Expr;

class MapperExpressionBuilder implements ExpressionBuilderInterface
{
    /**
     * @param string[] $fieldMapping
     */
    public function __construct(
        private ExpressionBuilderInterface $expressionBuilder,
        private array $fieldMapping = [],
    ) {}

    public function getSupportedTokenType(): int
    {
        return $this->expressionBuilder->getSupportedTokenType();
    }

    public function parameter(mixed $value, bool $isValue = false): mixed
    {
        return $this->expressionBuilder->parameter($value, $isValue);
    }

    public function string(mixed $value): mixed
    {
        return $this->expressionBuilder->string($value);
    }

    public function isNull(string $field): mixed
    {
        return $this->expressionBuilder->isNull($this->mapField($field));
    }

    public function eq(string $field, mixed $value): mixed
    {
        return $this->expressionBuilder->eq($this->mapField($field), $value);
    }

    public function neq(string $field, mixed $value): mixed
    {
        return $this->expressionBuilder->neq($this->mapField($field), $value);
    }

    public function gt(string $field, mixed $value): mixed
    {
        return $this->expressionBuilder->gt($this->mapField($field), $value);
    }

    public function gte(string $field, mixed $value): mixed
    {
        return $this->expressionBuilder->gte($this->mapField($field), $value);
    }

    public function lt(string $field, mixed $value): mixed
    {
        return $this->expressionBuilder->lt($this->mapField($field), $value);
    }

    public function lte(string $field, mixed $value): mixed
    {
        return $this->expressionBuilder->lte($this->mapField($field), $value);
    }

    public function in(string $field, array $values): mixed
    {
        return $this->expressionBuilder->in($this->mapField($field), $values);
    }

    public function notIn(string $field, array $values): mixed
    {
        return $this->expressionBuilder->notIn($this->mapField($field), $values);
    }

    public function contains(string $field, mixed $value): mixed
    {
        return $this->expressionBuilder->contains($this->mapField($field), $value);
    }

    public function notContains(string $field, mixed $value): mixed
    {
        return $this->expressionBuilder->notContains($this->mapField($field), $value);
    }

    public function andX(array $expressions): mixed
    {
        return $this->expressionBuilder->andX($expressions);
    }

    public function nandX(array $expressions): mixed
    {
        return $this->expressionBuilder->nandX($expressions);
    }

    public function orX(array $expressions): mixed
    {
        return $this->expressionBuilder->orX($expressions);
    }

    public function norX(array $expressions): mixed
    {
        return $this->expressionBuilder->norX($expressions);
    }

    public function xorX(array $expressions): mixed
    {
        return $this->expressionBuilder->xorX($expressions);
    }

    private function mapField(mixed $field): mixed
    {
        if (
            \is_array($field)
            || \is_object($field) && !method_exists($field, '__toString')
        ) {
            return $field;
        }

        if (\array_key_exists((string) $field, $this->fieldMapping)) {
            return sprintf($this->fieldMapping[(string) $field], $field);
        }

        if (\array_key_exists('*', $this->fieldMapping)) {
            return sprintf($this->fieldMapping['*'], $field);
        }

        return $field;
    }
}
