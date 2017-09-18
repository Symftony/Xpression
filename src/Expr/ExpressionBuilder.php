<?php

namespace Symftony\Xpression\Expr;

use Symftony\Xpression\Exception\ExpressionNotSupportedException;
use Symftony\Xpression\ExpressionBuilderInterface;

class ExpressionBuilder implements ExpressionBuilderInterface
{
    /**
     * @param array $expressions
     *
     * @return CompositeExpression
     */
    public function andX(array $expressions)
    {
        return new CompositeExpression(CompositeExpression::TYPE_AND, $expressions);
    }

    /**
     * @param array $expressions
     *
     * @throws ExpressionNotSupportedException
     */
    public function nandX(array $expressions)
    {
        throw new ExpressionNotSupportedException(__METHOD__);
    }

    /**
     * @param array $expressions
     *
     * @return CompositeExpression
     */
    public function orX(array $expressions)
    {
        return new CompositeExpression(CompositeExpression::TYPE_OR, $expressions);
    }

    /**
     * @param array $expressions
     *
     * @return CompositeExpression
     */
    public function norX(array $expressions)
    {
        return new CompositeExpression(CompositeExpression::TYPE_NOR, $expressions);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function eq($field, $value)
    {
        return new Comparison($field, Comparison::EQ, new Value($value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function gt($field, $value)
    {
        return new Comparison($field, Comparison::GT, new Value($value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function lt($field, $value)
    {
        return new Comparison($field, Comparison::LT, new Value($value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function gte($field, $value)
    {
        return new Comparison($field, Comparison::GTE, new Value($value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function lte($field, $value)
    {
        return new Comparison($field, Comparison::LTE, new Value($value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function neq($field, $value)
    {
        return new Comparison($field, Comparison::NEQ, new Value($value));
    }

    /**
     * @param string $field
     *
     * @return Comparison
     */
    public function isNull($field)
    {
        return new Comparison($field, Comparison::EQ, new Value(null));
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return Comparison
     */
    public function in($field, array $values)
    {
        return new Comparison($field, Comparison::IN, new Value($values));
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return Comparison
     */
    public function notIn($field, array $values)
    {
        return new Comparison($field, Comparison::NIN, new Value($values));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return Comparison
     */
    public function contains($field, $value)
    {
        return new Comparison($field, Comparison::CONTAINS, new Value($value));
    }
}
