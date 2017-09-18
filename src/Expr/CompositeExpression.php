<?php

namespace Symftony\Xpression\Expr;

class CompositeExpression implements CompositeExpressionInterface
{
    const TYPE_AND = 'AND';
//    const TYPE_NAND = 'NAND';
    const TYPE_OR = 'OR';
    const TYPE_NOR = 'NOR';

    /**
     * @var string
     */
    private $operator;

    /**
     * @var Expression[]
     */
    private $expressions = [];

    /**
     * @param string $operator
     * @param array $expressions
     */
    public function __construct($operator, array $expressions)
    {
        $this->operator = $operator;

        foreach ($expressions as $expr) {
            if (!($expr instanceof Comparison) && !($expr instanceof CompositeExpression)) {
                throw new \RuntimeException('No expression given to CompositeExpression.');
            }

            $this->expressions[] = $expr;
        }

        $this->expressions = $expressions;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return Expression[]
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * @param ExpressionVisitor $visitor
     * @param array $context
     *
     * @return mixed
     */
    public function visit(ExpressionVisitor $visitor, array $context = [])
    {
        return $visitor->walkCompositeExpression($this, $context);
    }
}
