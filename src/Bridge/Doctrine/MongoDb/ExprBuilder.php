<?php

namespace Symftony\Xpression\Bridge\Doctrine\MongoDb;

use Doctrine\MongoDB\Query\Expr;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;

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
     * @param string $field
     *
     * @return string
     */
    public function isNull($field)
    {
        return $this->createExpr()->field($field)->equals(null)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function eq($field, $value)
    {
        return $this->createExpr()->field($field)->equals($value)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function neq($field, $value)
    {
        return $this->createExpr()->field($field)->notEqual($value)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function gt($field, $value)
    {
        return $this->createExpr()->field($field)->gt($value)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function gte($field, $value)
    {
        return $this->createExpr()->field($field)->gte($value)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function lt($field, $value)
    {
        return $this->createExpr()->field($field)->lt($value)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function lte($field, $value)
    {
        return $this->createExpr()->field($field)->lte($value)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return array
     */
    public function in($field, array $values)
    {
        return $this->createExpr()->field($field)->in($values)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return array
     */
    public function notIn($field, array $values)
    {
        return $this->createExpr()->field($field)->notIn($values)->getQuery();
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return array
     */
    public function contains($field, $value)
    {
        return $this->createExpr()->field($field)->equals(new \MongoRegex(sprintf('/.*%s.*/', $value)))->getQuery();
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
            $expr->addAnd($expression)->getQuery();
        }

        return $expr->getQuery();
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
            $expr->addOr($expression)->getQuery();
        }

        return $expr->getQuery();
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
            $expr->addNor($expression)->getQuery();
        }

        return $expr->getQuery();
    }

    /**
     * @param array $expressions
     */
    public function xorX(array $expressions)
    {
        throw new UnsupportedExpressionTypeException('xorX');
    }
}
