<?php

namespace Symftony\Xpression\Expr;

interface ValueInterface extends VisitableInterface
{
    /**
     * @return mixed
     */
    public function getValue();
}
