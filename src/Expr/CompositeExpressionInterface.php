<?php

namespace Symftony\Xpression\Expr;

interface CompositeExpressionInterface extends VisitableInterface
{
    /**
     * @return string
     */
    public function getOperator();

    /**
     * Returns the list of expressions nested in this composite.
     *
     * @return ExpressionInterface[]
     */
    public function getExpressions();
}
