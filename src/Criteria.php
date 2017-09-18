<?php

namespace Symftony\Xpression;

use Symftony\Xpression\Expr\VisitableInterface;

class Criteria implements CriteriaInterface
{
    /**
     * @var
     */
    protected $expression;

    /**
     * @var
     */
    protected static $expressionBuilder;

    /**
     * Creates an instance of the class.
     *
     * @return Criteria
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Returns the expression builder.
     *
     * @return \Symftony\Xpression\ExpressionBuilder
     */
    public static function expr()
    {
        if (self::$expressionBuilder === null) {
            self::$expressionBuilder = new ExpressionBuilder();
        }

        return self::$expressionBuilder;
    }

    /**
     * @param VisitableInterface $expression
     *
     * @return $this
     */
    public function where(VisitableInterface $expression)
    {
        $this->expression = $expression;

        return $this;
    }

//    /**
//     * @param VisitableInterface $expression
//     *
//     * @return $this
//     */
//    public function andWhere(VisitableInterface $expression)
//    {
//        if ($this->expression === null) {
//            return $this->where($expression);
//        }
//
//        $this->expression = new CompositeExpression(CompositeExpression::TYPE_AND, array(
//            $this->expression, $expression
//        ));
//
//        return $this;
//    }
//
//    /**
//     * @param VisitableInterface $expression
//     *
//     * @return $this
//     */
//    public function orWhere(VisitableInterface $expression)
//    {
//        if ($this->expression === null) {
//            return $this->where($expression);
//        }
//
//        $this->expression = new CompositeExpression(CompositeExpression::TYPE_OR, array(
//            $this->expression, $expression
//        ));
//
//        return $this;
//    }
//
//    /**
//     * @param VisitableInterface $expression
//     *
//     * @return $this
//     */
//    public function norWhere(VisitableInterface $expression)
//    {
//        if ($this->expression === null) {
//            return $this->where($expression);
//        }
//
//        $this->expression = new CompositeExpression(CompositeExpression::TYPE_NOR, array(
//            $this->expression, $expression
//        ));
//
//        return $this;
//    }

    /**
     * @return mixed
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
