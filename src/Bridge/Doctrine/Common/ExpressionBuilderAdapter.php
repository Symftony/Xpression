<?php

namespace Symftony\Xpression\Bridge\Doctrine\Common;

use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;

class ExpressionBuilderAdapter implements ExpressionBuilderInterface
{
    /**
     * @var ExpressionBuilder
     */
    private $expressionBuilder;

    public function __construct(ExpressionBuilder $expressionBuilder)
    {
        $this->expressionBuilder = $expressionBuilder;
    }

    /**
     * @param string $field
     *
     * @return Comparison
     */
    public function isNull($field)
    {
        return $this->expressionBuilder->isNull($field);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function eq($field, $value)
    {
        return $this->expressionBuilder->eq($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function neq($field, $value)
    {
        return $this->expressionBuilder->neq($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function gt($field, $value)
    {
        return $this->expressionBuilder->gt($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function gte($field, $value)
    {
        return $this->expressionBuilder->gte($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function lt($field, $value)
    {
        return $this->expressionBuilder->lt($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function lte($field, $value)
    {
        return $this->expressionBuilder->lte($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return Comparison
     */
    public function in($field, array $values)
    {
        return $this->expressionBuilder->in($field, $values);
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return Comparison
     */
    public function notIn($field, array $values)
    {
        return $this->expressionBuilder->notIn($field, $values);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function contains($field, $value)
    {
        return $this->expressionBuilder->contains($field, $value);
    }

    /**
     * @param array $expressions
     *
     * @return CompositeExpression
     */
    public function andX(array $expressions)
    {
        return call_user_func_array(array($this->expressionBuilder, 'andX'), $expressions);
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
     * @return CompositeExpression
     */
    public function orX(array $expressions)
    {
        return call_user_func_array(array($this->expressionBuilder, 'orX'), $expressions);
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
