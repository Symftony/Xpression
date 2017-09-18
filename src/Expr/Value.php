<?php

namespace Symftony\Xpression\Expr;

class Value implements ValueInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
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
        return $visitor->walkValue($this, $context);
    }
}
