<?php

declare(strict_types=1);

namespace Symftony\Xpression;

use Doctrine\Common\Lexer\AbstractLexer;
use Symftony\Xpression\Exception\Lexer\UnknownTokenTypeException;

class Lexer extends AbstractLexer
{
    public const T_NONE = 0;
    public const T_ALL = 16777215;

    // Punctuation
    public const T_COMMA = 1; // 2**0

    // Operand
    public const T_OPERANDE = 30; // 2**1 + 2**2 + 2**3 + 2**4
    public const T_INTEGER = 2; // 2**1
    public const T_STRING = 4; // 2**2
    public const T_INPUT_PARAMETER = 8; // 2**3
    public const T_FLOAT = 16; // 2**4

    // Comparison operator
    public const T_COMPARISON = 7079904; // 2**5 + 2**6 + 2**7 + 2**8 + 2**9 + 2**10 + 2**18 + 2**19 + 2**21 + 2**22
    public const T_EQUALS = 32; // 2**5
    public const T_NOT_EQUALS = 64; // 2**6
    public const T_GREATER_THAN = 128; // 2**7
    public const T_GREATER_THAN_EQUALS = 256; // 2**8
    public const T_LOWER_THAN = 512; // 2**9
    public const T_LOWER_THAN_EQUALS = 1024; // 2**10

    // Composite operator
    public const T_COMPOSITE = 63488; // 2**11 + 2**12 + 2**13 + 2**14 + 2**15
    public const T_AND = 2048; // 2**11
    public const T_NOT_AND = 4096; // 2**12
    public const T_OR = 8192; // 2**13
    public const T_NOT_OR = 16384; // 2**14
    public const T_XOR = 32768; // 2**15

    // Brace
    public const T_OPEN_PARENTHESIS = 65536; // 2**16
    public const T_CLOSE_PARENTHESIS = 131072; // 2**17
    public const T_OPEN_SQUARE_BRACKET = 262144; // 2**18
    public const T_NOT_OPEN_SQUARE_BRACKET = 524288; // 2**19
    public const T_CLOSE_SQUARE_BRACKET = 1048576; // 2**20
    public const T_DOUBLE_OPEN_CURLY_BRACKET = 2097152; // 2**21
    public const T_NOT_DOUBLE_OPEN_CURLY_BRACKET = 4194304; // 2**22
    public const T_DOUBLE_CLOSE_CURLY_BRACKET = 8388608; // 2**23

    /**
     * @return string[]
     */
    public static function getTokenSyntax(mixed $tokenType): array
    {
        $tokenSyntax = [];
        // Punctuation
        if ($tokenType & self::T_COMMA) {
            $tokenSyntax[] = ',';
        }

        // Recognize numeric values
        if ($tokenType & self::T_FLOAT) {
            $tokenSyntax[] = 'simple float';
        }
        if ($tokenType & self::T_INTEGER) {
            $tokenSyntax[] = 'simple integer';
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
        if ($tokenType & self::T_DOUBLE_OPEN_CURLY_BRACKET) {
            $tokenSyntax[] = '{{';
        }
        if ($tokenType & self::T_NOT_DOUBLE_OPEN_CURLY_BRACKET) {
            $tokenSyntax[] = '!{{';
        }
        if ($tokenType & self::T_DOUBLE_CLOSE_CURLY_BRACKET) {
            $tokenSyntax[] = '}}';
        }

        return $tokenSyntax;
    }

    /**
     * @return array
     */
    protected function getCatchablePatterns()
    {
        return [
            "'(?:[^']|'')*'", // quoted strings
            '"(?:[^"]|"")*"', // quoted strings
            '\^\||⊕|!&|&|!\||\|', // Composite operator
            '≤|≥|≠|<=|>=|!=|<|>|=|\[|!\[|\]|!{{|{{|}}', // Comparison operator
            '[a-z_][a-z0-9_\.\-]*', // identifier or qualified name
            '(?:[+-]?[0-9]*(?:[\.][0-9]+)*)', // numbers
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
     * @throws UnknownTokenTypeException
     */
    protected function getType(&$value)
    {
        switch (true) {
            // Punctuation
            case ',' === $value[0]:
                $type = self::T_COMMA;

                break;

                // Recognize numeric values
            case is_numeric($value):
                if (str_contains($value, '.') || false !== stripos($value, 'e')) {
                    $value = (float) $value;
                    $type = self::T_FLOAT;

                    break;
                }

                $value = (int) $value;
                $type = self::T_INTEGER;

                break;

                // Recognize quoted strings
            case '"' === $value[0]:
                $value = str_replace('""', '"', substr($value, 1, \strlen($value) - 2));

                $type = self::T_STRING;

                break;

            case "'" === $value[0]:
                $value = str_replace("''", "'", substr($value, 1, \strlen($value) - 2));

                $type = self::T_STRING;

                break;

            case preg_match('/[a-z_][a-z0-9_]*/i', $value):
                $type = self::T_INPUT_PARAMETER;

                break;

                // Comparison operator
            case '=' === $value:
                $type = self::T_EQUALS;

                break;

            case '≠' === $value:
            case '!=' === $value:
                $value = '≠';
                $type = self::T_NOT_EQUALS;

                break;

            case '>' === $value:
                $type = self::T_GREATER_THAN;

                break;

            case '>=' === $value:
            case '≥' === $value:
                $value = '≥';
                $type = self::T_GREATER_THAN_EQUALS;

                break;

            case '<' === $value:
                $type = self::T_LOWER_THAN;

                break;

            case '<=' === $value:
            case '≤' === $value:
                $value = '≤';
                $type = self::T_LOWER_THAN_EQUALS;

                break;

                // Composite operator
            case '&' === $value:
                $type = self::T_AND;

                break;

            case '!&' === $value:
                $type = self::T_NOT_AND;

                break;

            case '|' === $value:
                $type = self::T_OR;

                break;

            case '!|' === $value:
                $type = self::T_NOT_OR;

                break;

            case '^|' === $value:
            case '⊕' === $value:
                $value = '⊕';
                $type = self::T_XOR;

                break;

                // Brace
            case '(' === $value:
                $type = self::T_OPEN_PARENTHESIS;

                break;

            case ')' === $value:
                $type = self::T_CLOSE_PARENTHESIS;

                break;

            case '[' === $value:
                $type = self::T_OPEN_SQUARE_BRACKET;

                break;

            case '![' === $value:
                $type = self::T_NOT_OPEN_SQUARE_BRACKET;

                break;

            case ']' === $value:
                $type = self::T_CLOSE_SQUARE_BRACKET;

                break;

            case '{{' === $value:
                $type = self::T_DOUBLE_OPEN_CURLY_BRACKET;

                break;

            case '!{{' === $value:
                $type = self::T_NOT_DOUBLE_OPEN_CURLY_BRACKET;

                break;

            case '}}' === $value:
                $type = self::T_DOUBLE_CLOSE_CURLY_BRACKET;

                break;

                // Default
            default:
                throw new UnknownTokenTypeException($value);
        }

        return $type;
    }
}
