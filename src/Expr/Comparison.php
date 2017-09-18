<?php

namespace Symftony\Xpression\Expr;

class Comparison implements ExpressionInterface
{
    const EQ = '=';
    const NEQ = '<>';
    const LT = '<';
    const LTE = '<=';
    const GT = '>';
    const GTE = '>=';
    const IN = 'IN';
    const NIN = 'NIN';
    const CONTAINS = 'CONTAINS';

    /**
     * @var
     */
    private $field;

    /**
     * @var
     */
    private $operator;

    /**
     * @var Value
     */
    private $value;

    /**
     * @param $field
     * @param $operator
     * @param $value
     */
    public function __construct($field, $operator, $value)
    {
        if (!($value instanceof Value)) {
            $value = new Value($value);
        }

        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return Value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function visit(ExpressionVisitor $visitor, array $context = [])
    {
        return $visitor->walkExpression($this, $context);
    }
}
