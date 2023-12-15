<?php

declare(strict_types=1);

namespace Symftony\Xpression\Expr;

use Symftony\Xpression\Lexer;

class HtmlExpressionBuilder implements ExpressionBuilderInterface
{
    /**
     * This callable is use to delegate the html generation to a third party
     * eg: $comparisonHtmlBuilder($field, $operator, $value)
     * it must return the html code.
     *
     * @var callable
     */
    private $comparisonHtmlBuilder;

    /**
     * This callable is use to delegate the html generation to a third party
     * eg: $compositeHtmlBuilder(array $expressions, $type)
     * it must return the html code.
     *
     * @var callable
     */
    private $compositeHtmlBuilder;

    public function __construct(callable $comparisonHtmlBuilder = null, callable $compositeHtmlBuilder = null)
    {
        $this->comparisonHtmlBuilder = $comparisonHtmlBuilder ?: static fn ($field, $operator, $value) => sprintf('<div>%s %s %s</div>', $field, $operator, $value);
        $this->compositeHtmlBuilder = $compositeHtmlBuilder ?: static fn (array $expressions, $type) => str_replace(
            ['{type}', '{expressions}'],
            [$type, implode('', $expressions)],
            '<fieldset><legend>{type}</legend>{expressions}</fieldset>'
        );
    }

    public function getSupportedTokenType(): int
    {
        return Lexer::T_ALL;
    }

    public function parameter(mixed $value, bool $isValue = false): mixed
    {
        return $value;
    }

    public function string(mixed $value): mixed
    {
        return '"'.$value.'"';
    }

    public function isNull(string $field): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, 'is', 'null');
    }

    public function eq(string $field, mixed $value): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, '=', $value);
    }

    public function neq(string $field, mixed $value): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, '≠', $value);
    }

    public function gt(string $field, mixed $value): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, '>', $value);
    }

    public function gte(string $field, mixed $value): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, '≥', $value);
    }

    public function lt(string $field, mixed $value): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, '<', $value);
    }

    public function lte(string $field, mixed $value): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, '≤', $value);
    }

    public function in(string $field, array $values): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, 'value in', implode(', ', $values));
    }

    public function notIn(string $field, array $values): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, 'value not in', implode(', ', $values));
    }

    public function contains(string $field, mixed $value): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, 'contains', $value);
    }

    public function notContains(string $field, mixed $value): mixed
    {
        return ($this->comparisonHtmlBuilder)($field, 'notContains', $value);
    }

    public function andX(array $expressions): mixed
    {
        return ($this->compositeHtmlBuilder)($expressions, 'and');
    }

    public function nandX(array $expressions): mixed
    {
        return ($this->compositeHtmlBuilder)($expressions, 'not-and');
    }

    public function orX(array $expressions): mixed
    {
        return ($this->compositeHtmlBuilder)($expressions, 'or');
    }

    public function norX(array $expressions): mixed
    {
        return ($this->compositeHtmlBuilder)($expressions, 'not-or');
    }

    public function xorX(array $expressions): mixed
    {
        return ($this->compositeHtmlBuilder)($expressions, 'exclusive-or');
    }
}
