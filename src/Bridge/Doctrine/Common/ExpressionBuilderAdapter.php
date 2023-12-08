<?php

namespace Symftony\Xpression\Bridge\Doctrine\Common;

use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Lexer;

class ExpressionBuilderAdapter implements ExpressionBuilderInterface
{
    private ExpressionBuilder $expressionBuilder;

    public function __construct(ExpressionBuilder $expressionBuilder)
    {
        $this->expressionBuilder = $expressionBuilder;
    }

    public function getSupportedTokenType(): int
    {
        return Lexer::T_ALL - Lexer::T_NOT_AND - Lexer::T_NOT_OR - Lexer::T_XOR - Lexer::T_NOT_DOUBLE_OPEN_CURLY_BRACKET;
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
        return $this->expressionBuilder->isNull($field);
    }

    public function eq(string $field, mixed $value)
    {
        return $this->expressionBuilder->eq($field, $value);
    }

    public function neq(string $field, mixed $value)
    {
        return $this->expressionBuilder->neq($field, $value);
    }

    public function gt(string $field, mixed $value)
    {
        return $this->expressionBuilder->gt($field, $value);
    }

    public function gte(string $field, mixed $value)
    {
        return $this->expressionBuilder->gte($field, $value);
    }

    public function lt(string $field, mixed $value)
    {
        return $this->expressionBuilder->lt($field, $value);
    }

    public function lte(string $field, mixed $value)
    {
        return $this->expressionBuilder->lte($field, $value);
    }

    public function in(string $field, array $values)
    {
        return $this->expressionBuilder->in($field, $values);
    }

    public function notIn(string $field, array $values)
    {
        return $this->expressionBuilder->notIn($field, $values);
    }

    /**
     * /!\ Contains operator appear only in doctrine/common v1.1 /!\
     */
    public function contains(string $field, mixed $value)
    {
        if (!method_exists($this->expressionBuilder, 'contains')) {
            throw new UnsupportedExpressionTypeException('contains');
        }

        return $this->expressionBuilder->contains($field, $value);
    }

    public function notContains(string $field, mixed $value)
    {
        throw new UnsupportedExpressionTypeException('notContains');
    }

    public function andX(array $expressions)
    {
        return call_user_func_array([$this->expressionBuilder, 'andX'], $expressions);
    }

    public function nandX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('nandX');
    }

    public function orX(array $expressions)
    {
        return call_user_func_array([$this->expressionBuilder, 'orX'], $expressions);
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
