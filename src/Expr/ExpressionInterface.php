<?php

namespace Symftony\Xpression\Expr;

interface ExpressionInterface extends VisitableInterface
{
    /**
     * @return string
     */
    public function getField();

    /**
     * @return string
     */
    public function getOperator();

    /**
     * @return ValueInterface
     */
    public function getValue();
}
