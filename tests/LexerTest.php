<?php

namespace Tests\Symftony\Xpression;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Lexer;

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
        return array(
            array(
                ',',
                array(
                    array('value' => ',', 'type' => Lexer::T_COMMA, 'position' => 0),
                ),
            ),
            array(
                '1',
                array(
                    array('value' => 1, 'type' => Lexer::T_INTEGER, 'position' => 0),
                ),
            ),
            array(
                '"value"',
                array(
                    array('value' => 'value', 'type' => Lexer::T_STRING, 'position' => 0),
                ),
            ),
            array(
                '\'value\'',
                array(
                    array('value' => 'value', 'type' => Lexer::T_STRING, 'position' => 0),
                ),
            ),
            array(
                'value',
                array(
                    array('value' => 'value', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                ),
            ),
            array(
                '1.5',
                array(
                    array('value' => 1.5, 'type' => Lexer::T_FLOAT, 'position' => 0),
                ),
            ),
            array(
                '=≠>≥<≤',
                array(
                    array('value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 0),
                    array('value' => '≠', 'type' => Lexer::T_NOT_EQUALS, 'position' => 1),
                    array('value' => '>', 'type' => Lexer::T_GREATER_THAN, 'position' => 4),
                    array('value' => '≥', 'type' => Lexer::T_GREATER_THAN_EQUALS, 'position' => 5),
                    array('value' => '<', 'type' => Lexer::T_LOWER_THAN, 'position' => 8),
                    array('value' => '≤', 'type' => Lexer::T_LOWER_THAN_EQUALS, 'position' => 9),
                ),
            ),
            array(
                '&!&|!|⊕',
                array(
                    array('value' => '&', 'type' => Lexer::T_AND, 'position' => 0),
                    array('value' => '!&', 'type' => Lexer::T_NOT_AND, 'position' => 1),
                    array('value' => '|', 'type' => Lexer::T_OR, 'position' => 3),
                    array('value' => '!|', 'type' => Lexer::T_NOT_OR, 'position' => 4),
                    array('value' => '⊕', 'type' => Lexer::T_XOR, 'position' => 6),
                ),
            ),
            array(
                '()[![]{{!{{}}',
                array(
                    array('value' => '(', 'type' => Lexer::T_OPEN_PARENTHESIS, 'position' => 0),
                    array('value' => ')', 'type' => Lexer::T_CLOSE_PARENTHESIS, 'position' => 1),
                    array('value' => '[', 'type' => Lexer::T_OPEN_SQUARE_BRACKET, 'position' => 2),
                    array('value' => '![', 'type' => Lexer::T_NOT_OPEN_SQUARE_BRACKET, 'position' => 3),
                    array('value' => ']', 'type' => Lexer::T_CLOSE_SQUARE_BRACKET, 'position' => 5),
                    array('value' => '{{', 'type' => Lexer::T_DOUBLE_OPEN_CURLY_BRACKET, 'position' => 6),
                    array('value' => '!{{', 'type' => Lexer::T_NOT_DOUBLE_OPEN_CURLY_BRACKET, 'position' => 8),
                    array('value' => '}}', 'type' => Lexer::T_DOUBLE_CLOSE_CURLY_BRACKET, 'position' => 11),
                ),
            ),
        );
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
        return array(
            array(
                '!',
            ),
            array(
                '§',
            ),
            array(
                '^',
            ),
            array(
                ';',
            ),
            array(
                ':',
            ),
            array(
                '/',
            ),
        );
    }

    /**
     * @dataProvider unexpectedValueExceptionProvider
     *
     * @expectedException \Symftony\Xpression\Exception\Lexer\UnknownTokenTypeException
     * @expectedExceptionMessageRegExp /Unknown token type ".+"\./
     *
     * @param $input
     */
    public function testUnexpectedValueException($input)
    {
        $this->lexer->setInput($input);
    }

    public function getTokenSyntaxDataProvider()
    {
        return array(
            array(
                0,
                array()
            ),
            array(
                1,
                array(',')
            ),
            array(
                Lexer::T_ALL,
                array(
                    ',',
                    'simple float',
                    'simple integer',
                    '/[a-z_][a-z0-9_]*/',
                    '"value" or \'value\'',
                    '=',
                    '≠ or !=',
                    '>',
                    '≥ or >=',
                    '<',
                    '≤ or <=',
                    '&',
                    '!&',
                    '|',
                    '!|',
                    '⊕ or ^|',
                    '(',
                    ')',
                    '[',
                    '![',
                    ']',
                    '{{',
                    '!{{',
                    '}}',
                )
            ),
        );
    }

    /**
     * @dataProvider getTokenSyntaxDataProvider
     *
     * @param $tokenType
     * @param $expectedSyntax
     */
    public function testGetTokenSyntax($tokenType, $expectedSyntax)
    {
        $this->assertEquals($expectedSyntax, Lexer::getTokenSyntax($tokenType));
    }
}
