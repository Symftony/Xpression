<?php

declare(strict_types=1);

namespace Symftony\Xpression\Expr;

use Symftony\Xpression\Lexer;

class ClosureExpressionBuilder implements ExpressionBuilderInterface
{
    public static function getObjectFieldValue(mixed $object, mixed $field): mixed
    {
        if (\is_array($object)) {
            return $object[$field];
        }

        $accessors = ['get', 'is'];

        foreach ($accessors as $accessor) {
            $accessor .= $field;

            if (!method_exists($object, $accessor)) {
                continue;
            }

            return $object->{$accessor}();
        }

        // __call should be triggered for get.
        $accessor = $accessors[0].$field;

        if (method_exists($object, '__call')) {
            return $object->{$accessor}();
        }

        if ($object instanceof \ArrayAccess) {
            return $object[$field];
        }

        if (isset($object->{$field})) {
            return $object->{$field};
        }

        // camelcase field name to support different variable naming conventions
        $ccField = preg_replace_callback('/_(.?)/', static fn ($matches) => strtoupper($matches[1]), $field);

        foreach ($accessors as $accessor) {
            $accessor .= $ccField;

            if (!method_exists($object, $accessor)) {
                continue;
            }

            return $object->{$accessor}();
        }

        return $object->{$field};
    }

    public function getSupportedTokenType(): int
    {
        return Lexer::T_ALL;
    }

    /**
     * @param bool  $isValue
     * @param mixed $value
     */
    public function parameter($value, $isValue = false): mixed
    {
        return $value;
    }

    public function string(mixed $value): mixed
    {
        return $value;
    }

    public function isNull(string $field): mixed
    {
        return static fn ($object) => null === ClosureExpressionBuilder::getObjectFieldValue($object, $field);
    }

    public function eq(string $field, mixed $value): mixed
    {
        return static fn ($object) => ClosureExpressionBuilder::getObjectFieldValue($object, $field) === $value;
    }

    public function neq(string $field, mixed $value): mixed
    {
        return static fn ($object) => ClosureExpressionBuilder::getObjectFieldValue($object, $field) !== $value;
    }

    public function gt(string $field, mixed $value): mixed
    {
        return static fn ($object) => ClosureExpressionBuilder::getObjectFieldValue($object, $field) > $value;
    }

    public function gte(string $field, mixed $value): mixed
    {
        return static fn ($object) => ClosureExpressionBuilder::getObjectFieldValue($object, $field) >= $value;
    }

    public function lt(string $field, mixed $value): mixed
    {
        return static fn ($object) => ClosureExpressionBuilder::getObjectFieldValue($object, $field) < $value;
    }

    public function lte(string $field, mixed $value): mixed
    {
        return static fn ($object) => ClosureExpressionBuilder::getObjectFieldValue($object, $field) <= $value;
    }

    public function in(string $field, array $values): mixed
    {
        return static fn ($object) => \in_array(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $values, true);
    }

    public function notIn(string $field, array $values): mixed
    {
        return static fn ($object) => !\in_array(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $values, true);
    }

    public function contains(string $field, mixed $value): mixed
    {
        return static fn ($object) => str_contains(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $value);
    }

    public function notContains(string $field, mixed $value): mixed
    {
        return static fn ($object) => !str_contains(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $value);
    }

    public function andX(array $expressions): mixed
    {
        return static function ($object) use ($expressions) {
            foreach ($expressions as $expression) {
                if (!$expression($object)) {
                    return false;
                }
            }

            return true;
        };
    }

    public function nandX(array $expressions): mixed
    {
        $self = $this;

        return static fn ($object) => !$self->andX($expressions)($object);
    }

    public function orX(array $expressions): mixed
    {
        return static function ($object) use ($expressions) {
            foreach ($expressions as $expression) {
                if ($expression($object)) {
                    return true;
                }
            }

            return false;
        };
    }

    public function norX(array $expressions): mixed
    {
        $self = $this;

        return static fn ($object) => !$self->orX($expressions)($object);
    }

    public function xorX(array $expressions): mixed
    {
        return static function ($object) use ($expressions) {
            $result = 0;
            foreach ($expressions as $expression) {
                if ($expression($object)) {
                    ++$result;
                }
            }

            $countExpressions = \count($expressions);

            return 1 === $result | (2 < $countExpressions & $result === $countExpressions);
        };
    }
}
