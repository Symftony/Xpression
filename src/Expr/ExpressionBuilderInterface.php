<?php

namespace Symftony\Xpression\Expr;

interface ExpressionBuilderInterface
{
    /**
     * Must return all supported token type
     *
     * @return int
     */
    public function getSupportedTokenType();

    /**
     * @param string $field
     */
    public function isNull($field);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function eq($field, $value);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function neq($field, $value);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function gt($field, $value);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function gte($field, $value);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function lt($field, $value);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function lte($field, $value);

    /**
     * @param string $field
     * @param mixed $values
     */
    public function in($field, array $values);

    /**
     * @param string $field
     * @param mixed $values
     */
    public function notIn($field, array $values);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function contains($field, $value);

    /**
     * @param string $field
     * @param mixed $value
     */
    public function notContains($field, $value);

    /**
     * @param array $expressions
     */
    public function andX(array $expressions);

    /**
     * @param array $expressions
     */
    public function nandX(array $expressions);

    /**
     * @param array $expressions
     */
    public function orX(array $expressions);

    /**
     * @param array $expressions
     */
    public function norX(array $expressions);

    /**
     * @param array $expressions
     */
    public function xorX(array $expressions);
}
