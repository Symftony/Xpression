<?php

namespace Tests\Symftony\Xpression;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Exception\Lexer\UnknownTokenTypeException;
use Symftony\Xpression\Lexer;

class LexerTest extends TestCase
{
    private Lexer $lexer;

    public function setUp(): void
    {
        $this->lexer = new Lexer();
    }

    public function setInputSuccessDataProvider():array
    {
        return [
            [
                'a=1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2],
                ],
            ],
            [
                'a.b=1',
                [
                    ['value' => 'a.b', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 3],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4],
                ],
            ],
            [
                'a-b=1',
                [
                    ['value' => 'a-b', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 3],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4],
                ],
            ],
            [
                'a≠1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '≠', 'type' => Lexer::T_NOT_EQUALS, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4],
                ],
            ],
            [
                'a!=1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '≠', 'type' => Lexer::T_NOT_EQUALS, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3],
                ],
            ],
            [
                'a="value"',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 1],
                    ['value' => 'value', 'type' => Lexer::T_STRING, 'position' => 2],
                ],
            ],
            [
                "a='value'",
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 1],
                    ['value' => 'value', 'type' => Lexer::T_STRING, 'position' => 2],
                ],
            ],
            [
                'a>1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '>', 'type' => Lexer::T_GREATER_THAN, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2],
                ],
            ],
            [
                'a>=1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '≥', 'type' => Lexer::T_GREATER_THAN_EQUALS, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3],
                ],
            ],
            [
                'a≥1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '≥', 'type' => Lexer::T_GREATER_THAN_EQUALS, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4],
                ],
            ],
            [
                'a<1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '<', 'type' => Lexer::T_LOWER_THAN, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2],
                ],
            ],
            [
                'a<=1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '≤', 'type' => Lexer::T_LOWER_THAN_EQUALS, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3],
                ],
            ],
            [
                'a≤1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '≤', 'type' => Lexer::T_LOWER_THAN_EQUALS, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4],
                ],
            ],
            [
                'a|1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '|', 'type' => Lexer::T_OR, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2],
                ],
            ],
            [
                'a!|1',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '!|', 'type' => Lexer::T_NOT_OR, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3],
                ],
            ],
            [
                'a[1,2]',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '[', 'type' => Lexer::T_OPEN_SQUARE_BRACKET, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2],
                    ['value' => ',', 'type' => Lexer::T_COMMA, 'position' => 3],
                    ['value' => '2', 'type' => Lexer::T_INTEGER, 'position' => 4],
                    ['value' => ']', 'type' => Lexer::T_CLOSE_SQUARE_BRACKET, 'position' => 5],
                ],
            ],
            [
                'a![1,2]',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '![', 'type' => Lexer::T_NOT_OPEN_SQUARE_BRACKET, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3],
                    ['value' => ',', 'type' => Lexer::T_COMMA, 'position' => 4],
                    ['value' => '2', 'type' => Lexer::T_INTEGER, 'position' => 5],
                    ['value' => ']', 'type' => Lexer::T_CLOSE_SQUARE_BRACKET, 'position' => 6],
                ],
            ],
            [
                'a{{1}}',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '{{', 'type' => Lexer::T_DOUBLE_OPEN_CURLY_BRACKET, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3],
                    ['value' => '}}', 'type' => Lexer::T_DOUBLE_CLOSE_CURLY_BRACKET, 'position' => 4],
                ],
            ],
            [
                'a!{{1}}',
                [
                    ['value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0],
                    ['value' => '!{{', 'type' => Lexer::T_NOT_DOUBLE_OPEN_CURLY_BRACKET, 'position' => 1],
                    ['value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4],
                    ['value' => '}}', 'type' => Lexer::T_DOUBLE_CLOSE_CURLY_BRACKET, 'position' => 5],
                ],
            ],
        ];
    }

    /**
     * @dataProvider setInputSuccessDataProvider
     */
    public function testSetInputSuccess(string $input, array $expectedTokens)
    {
        $this->lexer->setInput($input);
        $this->lexer->moveNext();
        $this->lexer->moveNext();
        $i = 0;
        while ($currentToken = $this->lexer->token) {
            $this->assertEquals($expectedTokens[$i], $currentToken);
            $this->lexer->moveNext();
            $i++;
        }
    }

    public function unexpectedValueExceptionProvider()
    {
        return [
            [
                '!',
            ],
            [
                '§',
            ],
            [
                '^',
            ],
            [
                ';',
            ],
            [
                ':',
            ],
            [
                '/',
            ],
        ];
    }

    /**
     * @dataProvider unexpectedValueExceptionProvider
     */
    public function testUnexpectedValueException(string $input)
    {
        $this->expectException(UnknownTokenTypeException::class);
        $this->expectExceptionMessageMatches('/Unknown token type ".+"\./');
        $this->lexer->setInput($input);
    }
}
