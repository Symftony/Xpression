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
                'a=1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2),
                ),
            ),
            array(
                'a.b=1',
                array(
                    array('value' => 'a.b', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 3),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4),
                ),
            ),
            array(
                'a≠1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '≠', 'type' => Lexer::T_NOT_EQUALS, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4),
                ),
            ),
            array(
                'a!=1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '≠', 'type' => Lexer::T_NOT_EQUALS, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3),
                ),
            ),
            array(
                'a="value"',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 1),
                    array('value' => 'value', 'type' => Lexer::T_STRING, 'position' => 2),
                ),
            ),
            array(
                "a='value'",
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '=', 'type' => Lexer::T_EQUALS, 'position' => 1),
                    array('value' => 'value', 'type' => Lexer::T_STRING, 'position' => 2),
                ),
            ),
            array(
                'a>1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '>', 'type' => Lexer::T_GREATER_THAN, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2),
                ),
            ),
            array(
                'a>=1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '≥', 'type' => Lexer::T_GREATER_THAN_EQUALS, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3),
                ),
            ),
            array(
                'a≥1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '≥', 'type' => Lexer::T_GREATER_THAN_EQUALS, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4),
                ),
            ),
            array(
                'a<1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '<', 'type' => Lexer::T_LOWER_THAN, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2),
                ),
            ),
            array(
                'a<=1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '≤', 'type' => Lexer::T_LOWER_THAN_EQUALS, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3),
                ),
            ),
            array(
                'a≤1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '≤', 'type' => Lexer::T_LOWER_THAN_EQUALS, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 4),
                ),
            ),
            array(
                'a|1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '|', 'type' => Lexer::T_OR, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2),
                ),
            ),
            array(
                'a!|1',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '!|', 'type' => Lexer::T_NOT_OR, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3),
                ),
            ),
            array(
                'a[1,2]',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '[', 'type' => Lexer::T_OPEN_SQUARE_BRACKET, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 2),
                    array('value' => ',', 'type' => Lexer::T_COMMA, 'position' => 3),
                    array('value' => '2', 'type' => Lexer::T_INTEGER, 'position' => 4),
                    array('value' => ']', 'type' => Lexer::T_CLOSE_SQUARE_BRACKET, 'position' => 5),
                ),
            ),
            array(
                'a![1,2]',
                array(
                    array('value' => 'a', 'type' => Lexer::T_INPUT_PARAMETER, 'position' => 0),
                    array('value' => '![', 'type' => Lexer::T_NOT_OPEN_SQUARE_BRACKET, 'position' => 1),
                    array('value' => '1', 'type' => Lexer::T_INTEGER, 'position' => 3),
                    array('value' => ',', 'type' => Lexer::T_COMMA, 'position' => 4),
                    array('value' => '2', 'type' => Lexer::T_INTEGER, 'position' => 5),
                    array('value' => ']', 'type' => Lexer::T_CLOSE_SQUARE_BRACKET, 'position' => 6),
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
}
