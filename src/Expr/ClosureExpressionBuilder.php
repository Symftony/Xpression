<?php

namespace Symftony\Xpression\Expr;

use Symftony\Xpression\Lexer;

class ClosureExpressionBuilder implements ExpressionBuilderInterface
{
    /**
     * @param $object
     * @param $field
     *
     * @return mixed
     */
    public static function getObjectFieldValue($object, $field)
    {
        if (is_array($object)) {
            return $object[$field];
        }

        $accessors = ['get', 'is'];

        foreach ($accessors as $accessor) {
            $accessor .= $field;

            if (!method_exists($object, $accessor)) {
                continue;
            }

            return $object->$accessor();
        }

        // __call should be triggered for get.
        $accessor = $accessors[0] . $field;

        if (method_exists($object, '__call')) {
            return $object->$accessor();
        }

        if ($object instanceof \ArrayAccess) {
            return $object[$field];
        }

        if (isset($object->$field)) {
            return $object->$field;
        }

        // camelcase field name to support different variable naming conventions
        $ccField = preg_replace_callback('/_(.?)/', function ($matches) {
            return strtoupper($matches[1]);
        }, $field);

        foreach ($accessors as $accessor) {
            $accessor .= $ccField;


            if (!method_exists($object, $accessor)) {
                continue;
            }

            return $object->$accessor();
        }

        return $object->$field;
    }

    /**
     * @return int
     */
    public function getSupportedTokenType(): int
    {
        return Lexer::T_ALL;
    }

    /**
     * @param $value
     * @param bool $isValue
     *
     * @return mixed
     */
    public function parameter($value, $isValue = false): mixed
    {
        return $value;
    }

    public function string($value): mixed
    {
        return $value;
    }

    public function isNull($field)
    {
        return function ($object) use ($field) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) === null;
        };
    }

    public function eq(string $field, mixed $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) === $value;
        };
    }

    public function neq(string $field, mixed $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) !== $value;
        };
    }

    public function gt(string $field, mixed $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) > $value;
        };
    }

    public function gte(string $field, mixed $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) >= $value;
        };
    }

    public function lt(string $field, mixed $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) < $value;
        };
    }

    public function lte(string $field, mixed $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) <= $value;
        };
    }

    public function in($field, array $values)
    {
        return function ($object) use ($field, $values) {
            return in_array(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $values);
        };
    }

    public function notIn($field, array $values)
    {
        return function ($object) use ($field, $values) {
            return !in_array(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $values);
        };
    }

    public function contains(string $field, mixed $value)
    {
        return function ($object) use ($field, $value) {
            return false !== strpos(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $value);
        };
    }

    public function notContains(string $field, mixed $value)
    {
        $self = $this;
        return function ($object) use ($self, $field, $value) {
            $contains = $self->contains($field, $value);
            return !$contains($object);
        };
    }

    public function andX(array $expressions)
    {
        return function ($object) use ($expressions) {
            foreach ($expressions as $expression) {
                if (!$expression($object)) {
                    return false;
                }
            }

            return true;
        };
    }

    public function nandX(array $expressions)
    {
        $self = $this;
        return function ($object) use ($self, $expressions) {
            $andX = $self->andX($expressions);
            return !$andX($object);
        };
    }

    public function orX(array $expressions)
    {
        return function ($object) use ($expressions) {
            foreach ($expressions as $expression) {
                if ($expression($object)) {
                    return true;
                }
            }

            return false;
        };
    }

    public function norX(array $expressions)
    {
        $self = $this;
        return function ($object) use ($self, $expressions) {
            $orX = $self->orX($expressions);
            return !$orX($object);
        };
    }

    public function xorX(array $expressions)
    {
        return function ($object) use ($expressions) {
            $result = 0;
            foreach ($expressions as $expression) {
                if ($expression($object)) {
                    $result++;
                }
            }

            $countExpressions = count($expressions);
            return $result === 1 | (2 < $countExpressions & $result === $countExpressions);
        };
    }
}
