<?php

namespace Symftony\Xpression;

use Symftony\Xpression\Exception\LexerException;

class Lexer extends AbstractLexer
{
    const T_NONE = 2**1;

    // Punctuation
    const T_COMMA = 2**2;

    // Operand
    const T_INTEGER = 2**3;
    const T_STRING = 2**4;
    const T_INPUT_PARAMETER = 2**5;
    const T_FLOAT = 2**6;

    // Comparison operator
    const T_EQUALS = 2**7;
    const T_NOT_EQUALS = 2**8;
    const T_GREATER_THAN = 2**9;
    const T_GREATER_THAN_EQUALS = 2**10;
    const T_LOWER_THAN = 2**11;
    const T_LOWER_THAN_EQUALS = 2**12;

    // Composite operator
    const T_AND = 2**13;
    const T_NOT_AND = 2**14;
    const T_OR = 2**15;
    const T_NOT_OR = 2**16;
    const T_XOR = 2**17;

    // Brace
    const T_OPEN_PARENTHESIS = 2**18;
    const T_CLOSE_PARENTHESIS = 2**19;
    const T_OPEN_SQUARE_BRACKET = 2**20;
    const T_NOT_OPEN_SQUARE_BRACKET = 2**21;
    const T_CLOSE_SQUARE_BRACKET = 2**22;
    const T_OPEN_CURLY_BRACKET = 2**23;
    const T_CLOSE_CURLY_BRACKET = 2**24;

    /**
     * @return array
     */
    protected function getCatchablePatterns()
    {
        return [
            "'(?:[^']|'')*'", // quoted strings
            '"(?:[^"]|"")*"', // quoted strings
            '\^\||⊕|!&|&|!\||\|', // Composite operator
            '≤|≥|≠|<=|>=|!=|<|>|=|\[|!\[|\]', // Comparison operator
            '[a-z_][a-z0-9_]*', // identifier or qualified name
            '(?:[+-]?[0-9]*(?:[\.][0-9]+)*)(?:e[+-]?[0-9]+)?', // numbers
        ];
    }

    /**
     * @return array
     */
    protected function getNonCatchablePatterns()
    {
        return [
            '\s+',
            '(.)',
        ];
    }

    /**
     * @param string $value
     *
     * @return int
     *
     * @throws LexerException
     */
    protected function getType(&$value)
    {
        switch (true) {
            // Punctuation
            case ($value[0] === ','):
                $type = self::T_COMMA;
                break;

            // Recognize numeric values
            case (is_numeric($value)):
                if (strpos($value, '.') !== false || stripos($value, 'e') !== false) {
                    $value = (float) $value;
                    $type = self::T_FLOAT;
                    break;
                }

                $value = (int) $value;
                $type = self::T_INTEGER;
                break;

            case (preg_match('/[a-z_][a-z0-9_]*/', $value)):
                $type = self::T_INPUT_PARAMETER;
                break;

            // Recognize quoted strings
            case ($value[0] === '"'):
                $value = str_replace('""', '"', substr($value, 1, strlen($value) - 2));

                $type = self::T_STRING;
                break;
            case ($value[0] === "'"):
                $value = str_replace("''", "'", substr($value, 1, strlen($value) - 2));

                $type = self::T_STRING;
                break;

            // Comparison operator
            case ($value === '='):
                $type = self::T_EQUALS;
                break;
            case ($value === '≠'):
            case ($value === '!='):
                $value = '≠';
                $type = self::T_NOT_EQUALS;
                break;
            case ($value === '>'):
                $type = self::T_GREATER_THAN;
                break;
            case ($value === '>='):
            case ($value === '≥'):
                $value = '≥';
                $type = self::T_GREATER_THAN_EQUALS;
                break;
            case ($value === '<'):
                $type = self::T_LOWER_THAN;
                break;
            case ($value === '<='):
            case ($value === '≤'):
                $value = '≤';
                $type = self::T_LOWER_THAN_EQUALS;
                break;

            // Composite operator
            case ($value === '&'):
                $type = self::T_AND;
                break;
            case ($value === '!&'):
                $type = self::T_NOT_AND;
                break;
            case ($value === '|'):
                $type = self::T_OR;
                break;
            case ($value === '!|'):
                $type = self::T_NOT_OR;
                break;
            case ($value === '^|'):
            case ($value === '⊕'):
                $value = '⊕';
                $type = self::T_XOR;
                break;

            // Brace
            case ($value === '('):
                $type = self::T_OPEN_PARENTHESIS;
                break;
            case ($value === ')'):
                $type = self::T_CLOSE_PARENTHESIS;
                break;
            case ($value === '['):
                $type = self::T_OPEN_SQUARE_BRACKET;
                break;
            case ($value === '!['):
                $type = self::T_NOT_OPEN_SQUARE_BRACKET;
                break;
            case ($value === ']'):
                $type = self::T_CLOSE_SQUARE_BRACKET;
                break;
            case ($value === '{'):
                $type = self::T_OPEN_CURLY_BRACKET;
                break;
            case ($value === '}'):
                $type = self::T_CLOSE_CURLY_BRACKET;
                break;

            // Default
            default:
                throw new LexerException($value);
        }

        return $type;
    }
}
