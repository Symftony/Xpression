<?php

namespace Tests\Symftony\Xpression;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Lexer;
use Symftony\Xpression\Token;

class LexerTest extends TestCase
{
    /**
     * @var Lexer
     */
    private $lexer;

    public function setUp()
    {
        $this->lexer = new Lexer();
    }

    public function setInputSuccessDataProvider()
    {
        return [
            [
                'a=1',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '=', Lexer::T_EQUALS, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 2),
                ],
            ],
            [
                'a>1',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '>', Lexer::T_GREATER_THAN, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 2),
                ],
            ],
            [
                'a>=1',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '≥', Lexer::T_GREATER_THAN_EQUALS, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 3),
                ],
            ],
            [
                'a≥1',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '≥', Lexer::T_GREATER_THAN_EQUALS, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 4),
                ],
            ],
            [
                'a<1',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '<', Lexer::T_LOWER_THAN, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 2),
                ],
            ],
            [
                'a<=1',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '≤', Lexer::T_LOWER_THAN_EQUALS, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 3),
                ],
            ],
            [
                'a≤1',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '≤', Lexer::T_LOWER_THAN_EQUALS, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 4),
                ],
            ],
            [
                'a|1',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '|', Lexer::T_OR, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 2),
                ],
            ],
            [
                'a[1,2]',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '[', Lexer::T_OPEN_SQUARE_BRACKET, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 2),
                    new Token(3, ',', Lexer::T_COMMA, 3),
                    new Token(4, '2', Lexer::T_INTEGER, 4),
                    new Token(5, ']', Lexer::T_CLOSE_SQUARE_BRACKET, 5),
                ],
            ],
            [
                'a![1,2]',
                [
                    new Token(0, 'a', Lexer::T_INPUT_PARAMETER, 0),
                    new Token(1, '![', Lexer::T_NOT_OPEN_SQUARE_BRACKET, 1),
                    new Token(2, '1', Lexer::T_INTEGER, 3),
                    new Token(3, ',', Lexer::T_COMMA, 4),
                    new Token(4, '2', Lexer::T_INTEGER, 5),
                    new Token(5, ']', Lexer::T_CLOSE_SQUARE_BRACKET, 6),
                ],
            ],
        ];
    }

    /**
     * @dataProvider setInputSuccessDataProvider
     *
     * @param $input
     * @param $expectedTokens
     */
    public function testSetInputSuccess($input, $expectedTokens)
    {
        $this->lexer->setInput($input);
        $this->assertEquals($expectedTokens, $this->lexer->tokens);
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
     *
     * @expectedException \Symftony\Xpression\Exception\LexerException
     * @expectedExceptionMessageRegExp /Unexpected token ".+"./
     *
     * @param $input
     */
    public function testUnexpectedValueException($input)
    {
        $this->lexer->setInput($input);
    }
}
