<?php

namespace Symftony\Xpression\Expr;

interface VisitableInterface
{
    /**
     * @param ExpressionVisitor $visitor
     * @param array $context
     *
     * @return mixed
     */
    public function visit(ExpressionVisitor $visitor, array $context = []);
}
