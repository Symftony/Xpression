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

        $accessors = array('get', 'is');

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
    public function getSupportedTokenType()
    {
        return Lexer::T_ALL;
    }

    /**
     * @param string $field
     *
     * @return callable
     */
    public function isNull($field)
    {
        return function ($object) use ($field) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) === null;
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return callable
     */
    public function eq($field, $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) === $value;
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return callable
     */
    public function neq($field, $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) !== $value;
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return callable
     */
    public function gt($field, $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) > $value;
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return callable
     */
    public function gte($field, $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) >= $value;
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return callable
     */
    public function lt($field, $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) < $value;
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return callable
     */
    public function lte($field, $value)
    {
        return function ($object) use ($field, $value) {
            return ClosureExpressionBuilder::getObjectFieldValue($object, $field) <= $value;
        };
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return callable
     */
    public function in($field, array $values)
    {
        return function ($object) use ($field, $values) {
            return in_array(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $values);
        };
    }

    /**
     * @param string $field
     * @param mixed $values
     *
     * @return callable
     */
    public function notIn($field, array $values)
    {
        return function ($object) use ($field, $values) {
            return !in_array(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $values);
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return callable
     */
    public function contains($field, $value)
    {
        return function ($object) use ($field, $value) {
            return false !== strpos(ClosureExpressionBuilder::getObjectFieldValue($object, $field), $value);
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return callable
     */
    public function notContains($field, $value)
    {
        $self = $this;
        return function ($object) use ($self, $field, $value) {
            $contains = $self->contains($field, $value);
            return !$contains($object);
        };
    }

    /**
     * @param array $expressions
     *
     * @return callable
     */
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

    /**
     * @param array $expressions
     *
     * @return callable
     */
    public function nandX(array $expressions)
    {
        $self = $this;
        return function ($object) use ($self, $expressions) {
            $andX = $self->andX($expressions);
            return !$andX($object);
        };
    }

    /**
     * @param array $expressions
     *
     * @return callable
     */
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

    /**
     * @param array $expressions
     *
     * @return callable
     */
    public function norX(array $expressions)
    {
        $self = $this;
        return function ($object) use ($self, $expressions) {
            $orX = $self->orX($expressions);
            return !$orX($object);
        };
    }

    /**
     * @param array $expressions
     *
     * @return callable
     */
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
