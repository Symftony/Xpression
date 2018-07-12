<?php

namespace Symftony\Xpression\Bridge\Doctrine\MongoDb;

use Doctrine\MongoDB\Query\Expr;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Lexer;

class ExprBuilder implements ExpressionBuilderInterface
{
    /**
     * @return Expr
     */
    private function createExpr()
    {
        return new Expr();
    }

    /**
     * @return int
     */
    public function getSupportedTokenType()
    {
        return Lexer::T_ALL - Lexer::T_NOT_AND - Lexer::T_XOR;
    }

    /**
     * @param $value
     * @param bool $isValue
     *
     * @return mixed
     */
    public function parameter($value, $isValue = false)
    {
        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function string($value)
    {
        return $value;
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function isNull($field)
    {
        return $this->createExpr()->field($field)->equals(null);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function eq($field, $value)
    {
        return $this->createExpr()->field($field)->equals($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function neq($field, $value)
    {
        return $this->createExpr()->field($field)->notEqual($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function gt($field, $value)
    {
        return $this->createExpr()->field($field)->gt($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function gte($field, $value)
    {
        return $this->createExpr()->field($field)->gte($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function lt($field, $value)
    {
        return $this->createExpr()->field($field)->lt($value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function lte($field, $value)
    {
        return $this->createExpr()->field($field)->lte($value);
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return array
     */
    public function in($field, array $values)
    {
        return $this->createExpr()->field($field)->in($values);
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return array
     */
    public function notIn($field, array $values)
    {
        return $this->createExpr()->field($field)->notIn($values);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function contains($field, $value)
    {
        return $this->createExpr()->field($field)->equals(new \MongoRegex(sprintf('/.*%s.*/', $value)));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function notContains($field, $value)
    {
        return $this->createExpr()->field($field)->equals(new \MongoRegex(sprintf('/^((?!%s).)*$/', $value)));
    }

    /**
     * @param array $expressions
     *
     * @return array
     */
    public function andX(array $expressions)
    {
        $expr = $this->createExpr();
        foreach ($expressions as $expression) {
            $expr->addAnd($expression);
        }

        return $expr;
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
     * @return array
     */
    public function orX(array $expressions)
    {
        $expr = $this->createExpr();
        foreach ($expressions as $expression) {
            $expr->addOr($expression);
        }

        return $expr;
    }

    /**
     * @param array $expressions
     *
     * @return array
     */
    public function norX(array $expressions)
    {
        $expr = $this->createExpr();
        foreach ($expressions as $expression) {
            $expr->addNor($expression);
        }

        return $expr;
    }

    /**
     * @param array $expressions
     */
    public function xorX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('xorX');
    }
}
