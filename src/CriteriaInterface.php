<?php

namespace Symftony\Xpression;

use Symftony\Xpression\Expr\VisitableInterface;

interface CriteriaInterface
{
    /**
     * @param VisitableInterface $expression
     */
    public function where(VisitableInterface $expression);
}
