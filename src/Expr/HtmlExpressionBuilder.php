<?php

namespace Symftony\Xpression\Expr;

use Symftony\Xpression\Lexer;

class HtmlExpressionBuilder implements ExpressionBuilderInterface
{
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
     * @param callable $comparisonHtmlBuilder
     * @param callable $compositeHtmlBuilder
     */
    public function __construct(callable $comparisonHtmlBuilder = null, callable $compositeHtmlBuilder = null)
    {
        $this->comparisonHtmlBuilder = $comparisonHtmlBuilder ?: function ($field, $operator, $value) {
            return sprintf('<div>%s %s %s</div>', $field, $operator, $value);
        };
        $this->compositeHtmlBuilder = $compositeHtmlBuilder ?: function (array $expressions, $type) {
            return str_replace(
                ['{type}', '{expressions}'],
                [$type, implode('', $expressions)],
                '<fieldset><legend>{type}</legend>{expressions}</fieldset>'
            );
        };
    }

    public function getSupportedTokenType(): int
    {
        return Lexer::T_ALL;
    }

    public function parameter(mixed $value, bool $isValue = false): mixed
    {
        return $value;
    }

    public function string($value): mixed
    {
        return '"' . $value . '"';
    }

    public function isNull($field)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, 'is', 'null']);
    }

    public function eq(string $field, mixed $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, '=', $value]);
    }

    public function neq(string $field, mixed $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, '≠', $value]);
    }

    public function gt(string $field, mixed $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, '>', $value]);
    }

    public function gte(string $field, mixed $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, '≥', $value]);
    }

    public function lt(string $field, mixed $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, '<', $value]);
    }

    public function lte(string $field, mixed $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, '≤', $value]);
    }

    public function in($field, array $values)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, 'value in', implode(', ', $values)]);
    }

    public function notIn($field, array $values)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, 'value not in', implode(', ', $values)]);
    }

    public function contains(string $field, mixed $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, 'contains', $value]);
    }

    public function notContains(string $field, mixed $value)
    {
        return call_user_func_array($this->comparisonHtmlBuilder, [$field, 'notContains', $value]);
    }

    public function andX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, [$expressions, 'and']);
    }

    public function nandX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, [$expressions, 'not-and']);
    }

    public function orX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, [$expressions, 'or']);
    }

    public function norX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, [$expressions, 'not-or']);
    }

    public function xorX(array $expressions)
    {
        return call_user_func_array($this->compositeHtmlBuilder, [$expressions, 'exclusive-or']);
    }
}
