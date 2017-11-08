<?php

namespace Symftony\Xpression\Bridge\Doctrine\MongoDb;

use Doctrine\MongoDB\Query\Builder;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;

class BuilderAdapter implements ExpressionBuilderInterface
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function isNull($field)
    {
        return $this->builder->field($field)->equals(null);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function eq($field, $value)
    {
        return $this->builder->field($field)->equals($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function neq($field, $value)
    {
        return $this->builder->field($field)->notEqual($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function gt($field, $value)
    {
        return $this->builder->field($field)->gt($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function gte($field, $value)
    {
        return $this->builder->field($field)->gte($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function lt($field, $value)
    {
        return $this->builder->field($field)->lt($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function lte($field, $value)
    {
        return $this->builder->field($field)->lte($value);
    }

    /**
     * @param string $field
     * @param array $values
     *
     * @return $this
     */
    public function in($field, array $values)
    {
        return $this->builder->field($field)->in($values);
    }

    /**
     * @param string $field
     * @param array $values
     *
     * @return $this
     */
    public function notIn($field, array $values)
    {
        return $this->builder->field($field)->notIn($values);
    }

    /**
     * @param string $field
     * @param mixed $value
     */
    public function contains($field, $value)
    {
        throw new UnsupportedExpressionTypeException('contains');
    }

    /**
     * @param array $expressions
     *
     * @return mixed
     */
    public function andX(array $expressions)
    {
        return call_user_func_array(array($this->builder, 'addAnd'), $expressions);
    }

    /**
     * @param array $expressions
     *
     * @return mixed
     */
    public function nandX(array $expressions)
    {
        return call_user_func_array(array($this->builder, 'addAnd'), $expressions);
    }

    /**
     * @param array $expressions
     *
     * @return mixed
     */
    public function orX(array $expressions)
    {
        return call_user_func_array(array($this->builder, 'addOr'), $expressions);
    }

    /**
     * @param array $expressions
     *
     * @return mixed
     */
    public function norX(array $expressions)
    {
        return call_user_func_array(array($this->builder, 'addNor'), $expressions);
    }

    /**
     * @param array $expressions
     */
    public function xorX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('xorX');
    }
}