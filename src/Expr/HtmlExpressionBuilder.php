<?php

namespace Symftony\Xpression\Expr;

use Symftony\Xpression\Lexer;

class HtmlExpressionBuilder implements ExpressionBuilderInterface
{
    /**
     * @return int
     */
    public function getSupportedTokenType()
    {
        return Lexer::T_ALL;
    }

    /**
     * This callable is use to delegate the html generation to a third party
     * eg: $comparisonHtmlBuilder($field, $operator, $value)
     * it must return the html code
     *
     * @var callable
     */
    private $comparisonHtmlBuilder;

    /**
     * This callable is use to delegate the html generation to a third party
     * eg: $compositeHtmlBuilder(array $expressions, $type)
     * it must return the html code
     *
     * @var callable
     */
    private $compositeHtmlBuilder;

    /**
     * @param $comparisonHtmlBuilder
     * @param $compositeHtmlBuilder
     */
    public function __construct(callable $comparisonHtmlBuilder = null, callable $compositeHtmlBuilder = null)
    {
        $this->comparisonHtmlBuilder = $comparisonHtmlBuilder ?: function($field, $operator, $value) {
            return sprintf('<div>%s %s %s</div>', $field, $operator, $value);
        };
        $this->compositeHtmlBuilder = $compositeHtmlBuilder ?: function(array $expressions, $type) {
            return str_replace(
                array('{type}', '{expressions}'),
                array($type, implode('', $expressions)),
                '<fieldset><legend>{type}</legend>{expressions}</fieldset>');
        };
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function isNull($field)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, 'is', 'null'));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function eq($field, $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, '=', $value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function neq($field, $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, '≠', $value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function gt($field, $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, '>', $value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function gte($field, $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, '≥', $value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function lt($field, $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, '<', $value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function lte($field, $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, '≤', $value));
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return string
     */
    public function in($field, array $values)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, 'value in', implode(', ', $values)));
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return string
     */
    public function notIn($field, array $values)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, 'value not in', implode(', ', $values)));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function contains($field, $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, 'contains', $value));
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function notContains($field, $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, array($field, 'notContains', $value));
    }

    /**
     * @param array $expressions
     *
     * @return string
     */
    public function andX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, array($expressions, 'and'));
    }

    /**
     * @param array $expressions
     *
     * @return string
     */
    public function nandX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, array($expressions, 'not-and'));
    }

    /**
     * @param array $expressions
     *
     * @return string
     */
    public function orX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, array($expressions, 'or'));
    }

    /**
     * @param array $expressions
     *
     * @return string
     */
    public function norX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, array($expressions, 'not-or'));
    }

    /**
     * @param array $expressions
     *
     * @return string
     */
    public function xorX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, array($expressions, 'exclusive-or'));
    }
}
