<?php

namespace Symftony\Xpression\Expr;

class MapperExpressionBuilder implements ExpressionBuilderInterface
{
    private ExpressionBuilderInterface $expressionBuilder;

    private array $fieldMapping;

    /**
     * @param ExpressionBuilderInterface $expressionBuilder
     * @param array $fieldMapping
     */
    public function __construct(ExpressionBuilderInterface $expressionBuilder, array $fieldMapping = [])
    {
        $this->expressionBuilder = $expressionBuilder;
        $this->fieldMapping = $fieldMapping;
    }

    public function getSupportedTokenType(): int
    {
        return $this->expressionBuilder->getSupportedTokenType();
    }

    public function parameter(mixed $value, bool $isValue = false): mixed
    {
        return $this->expressionBuilder->parameter($value, $isValue);
    }

    public function string($value): mixed
    {
        return $this->expressionBuilder->string($value);
    }

    public function isNull($field)
    {
        return $this->expressionBuilder->isNull($this->mapField($field));
    }

    public function eq(string $field, mixed $value)
    {
        return $this->expressionBuilder->eq($this->mapField($field), $value);
    }

    public function neq(string $field, mixed $value)
    {
        return $this->expressionBuilder->neq($this->mapField($field), $value);
    }

    public function gt(string $field, mixed $value)
    {
        return $this->expressionBuilder->gt($this->mapField($field), $value);
    }

    public function gte(string $field, mixed $value)
    {
        return $this->expressionBuilder->gte($this->mapField($field), $value);
    }

    public function lt(string $field, mixed $value)
    {
        return $this->expressionBuilder->lt($this->mapField($field), $value);
    }

    public function lte(string $field, mixed $value)
    {
        return $this->expressionBuilder->lte($this->mapField($field), $value);
    }

    public function in($field, array $values)
    {
        return $this->expressionBuilder->in($this->mapField($field), $values);
    }

    public function notIn($field, array $values)
    {
        return $this->expressionBuilder->notIn($this->mapField($field), $values);
    }

    public function contains(string $field, mixed $value)
    {
        return $this->expressionBuilder->contains($this->mapField($field), $value);
    }

    public function notContains(string $field, mixed $value)
    {
        return $this->expressionBuilder->notContains($this->mapField($field), $value);
    }

    public function andX(array $expressions)
    {
        return $this->expressionBuilder->andX($expressions);
    }

    public function nandX(array $expressions)
    {
        return $this->expressionBuilder->nandX($expressions);
    }

    public function orX(array $expressions)
    {
        return $this->expressionBuilder->orX($expressions);
    }

    public function norX(array $expressions)
    {
        return $this->expressionBuilder->norX($expressions);
    }

    public function xorX(array $expressions)
    {
        return $this->expressionBuilder->xorX($expressions);
    }

    private function mapField($field)
    {
        if (
            is_array($field) ||
            is_object($field) && !method_exists($field, '__toString')
        ) {
            return $field;
        }

        if (array_key_exists((string)$field, $this->fieldMapping)) {
            return sprintf($this->fieldMapping[(string)$field], $field);
        }

        if (array_key_exists('*', $this->fieldMapping)) {
            return sprintf($this->fieldMapping['*'], $field);
        }

        return $field;
    }
}
