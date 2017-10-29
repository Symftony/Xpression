<?php

namespace Symftony\Xpression;

use Doctrine\Common\Lexer\AbstractLexer;
use Symftony\Xpression\Exception\Lexer\UnknownTokenTypeException;

class Lexer extends AbstractLexer
{
    const T_NONE = 1;

    // Punctuation
    const T_COMMA = 2;

    // Operand
    const T_OPERANDE = 60;
    const T_INTEGER = 4;
    const T_STRING = 8;
    const T_INPUT_PARAMETER = 16;
    const T_FLOAT = 32;

    // Comparison operator
    const T_COMPARISON = 4032;
    const T_EQUALS = 64;
    const T_NOT_EQUALS = 128;
    const T_GREATER_THAN = 256;
    const T_GREATER_THAN_EQUALS = 512;
    const T_LOWER_THAN = 1024;
    const T_LOWER_THAN_EQUALS = 2048;

    // Composite operator
    const T_COMPOSITE = 126976;
    const T_AND = 4096;
    const T_NOT_AND = 8192;
    const T_OR = 16384;
    const T_NOT_OR = 32768;
    const T_XOR = 65536;

    // Brace
    const T_OPEN_PARENTHESIS = 131072;
    const T_CLOSE_PARENTHESIS = 262144;
    const T_OPEN_SQUARE_BRACKET = 524288;
    const T_NOT_OPEN_SQUARE_BRACKET = 1048576;
    const T_CLOSE_SQUARE_BRACKET = 2097152;
    const T_OPEN_CURLY_BRACKET = 4194304;
    const T_CLOSE_CURLY_BRACKET = 8388608;

    /**
     * @return array
     */
    protected function getCatchablePatterns()
    {
        return array(
            "'(?:[^']|'')*'", // quoted strings
            '"(?:[^"]|"")*"', // quoted strings
            '\^\||⊕|!&|&|!\||\|', // Composite operator
            '≤|≥|≠|<=|>=|!=|<|>|=|\[|!\[|\]', // Comparison operator
            '[a-z_][a-z0-9_]*', // identifier or qualified name
            '(?:[+-]?[0-9]*(?:[\.][0-9]+)*)(?:e[+-]?[0-9]+)?', // numbers
        );
    }

    /**
     * @return array
     */
    protected function getNonCatchablePatterns()
    {
        return array(
            '\s+',
            '(.)',
        );
    }

    /**
     * @param string $value
     *
     * @return int
     *
     * @throws UnknownTokenTypeException
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

            // Recognize quoted strings
            case ($value[0] === '"'):
                $value = str_replace('""', '"', substr($value, 1, strlen($value) - 2));

                $type = self::T_STRING;
                break;
            case ($value[0] === "'"):
                $value = str_replace("''", "'", substr($value, 1, strlen($value) - 2));

                $type = self::T_STRING;
                break;

            case (preg_match('/[a-z_][a-z0-9_]*/i', $value)):
                $type = self::T_INPUT_PARAMETER;
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
                throw new UnknownTokenTypeException($value);
        }

        return $type;
    }

    /**
     * @param $tokenType
     *
     * @return array
     */
    public function getTokenSyntax($tokenType)
    {
        $tokenSyntax = array();
        // Punctuation
        if ($tokenType & self::T_COMMA) {
            $tokenSyntax[] = ',';
        }

        // Recognize numeric values
        if ($tokenType & self::T_FLOAT) {
            $tokenSyntax[] = 'all float format';
        }
        if ($tokenType & self::T_INTEGER) {
            $tokenSyntax[] = 'all numeric format';
        }
        if ($tokenType & self::T_INPUT_PARAMETER) {
            $tokenSyntax[] = '/[a-z_][a-z0-9_]*/';
        }

        // Recognize quoted strings
        if ($tokenType & self::T_STRING) {
            $tokenSyntax[] = '"value" or \'value\'';
        }

        // Comparison operator
        if ($tokenType & self::T_EQUALS) {
            $tokenSyntax[] = '=';
        }
        if ($tokenType & self::T_NOT_EQUALS) {
            $tokenSyntax[] = '≠ or !=';
        }
        if ($tokenType & self::T_GREATER_THAN) {
            $tokenSyntax[] = '>';
        }
        if ($tokenType & self::T_GREATER_THAN_EQUALS) {
            $tokenSyntax[] = '≥ or >=';
        }
        if ($tokenType & self::T_LOWER_THAN) {
            $tokenSyntax[] = '<';
        }
        if ($tokenType & self::T_LOWER_THAN_EQUALS) {
            $tokenSyntax[] = '≤ or <=';
        }

        // Composite operator
        if ($tokenType & self::T_AND) {
            $tokenSyntax[] = '&';
        }
        if ($tokenType & self::T_NOT_AND) {
            $tokenSyntax[] = '!&';
        }
        if ($tokenType & self::T_OR) {
            $tokenSyntax[] = '|';
        }
        if ($tokenType & self::T_NOT_OR) {
            $tokenSyntax[] = '!|';
        }
        if ($tokenType & self::T_XOR) {
            $tokenSyntax[] = '⊕ or ^|';
        }

        // Brace
        if ($tokenType & self::T_OPEN_PARENTHESIS) {
            $tokenSyntax[] = '(';
        }
        if ($tokenType & self::T_CLOSE_PARENTHESIS) {
            $tokenSyntax[] = ')';
        }
        if ($tokenType & self::T_OPEN_SQUARE_BRACKET) {
            $tokenSyntax[] = '[';
        }
        if ($tokenType & self::T_NOT_OPEN_SQUARE_BRACKET) {
            $tokenSyntax[] = '![';
        }
        if ($tokenType & self::T_CLOSE_SQUARE_BRACKET) {
            $tokenSyntax[] = ']';
        }
        if ($tokenType & self::T_OPEN_CURLY_BRACKET) {
            $tokenSyntax[] = '{';
        }
        if ($tokenType & self::T_CLOSE_CURLY_BRACKET) {
            $tokenSyntax[] = '}';
        }

        return $tokenSyntax;
    }
}
