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
        $this->lexer = new Lexer(array(
            new Lexer\CommaTokenType(),
            new Lexer\FloatTokenType(),
            new Lexer\IntegerTokenType(),
            new Lexer\StringTokenType(),
            new Lexer\InputParameterTokenType(),
            new Lexer\EqualTokenType(),
            new Lexer\NotEqualTokenType(),
            new Lexer\GreaterThanTokenType(),
            new Lexer\GreaterThanEqualTokenType(),
            new Lexer\LowerThanTokenType(),
            new Lexer\LowerThanEqualTokenType(),
            new Lexer\NotAndTokenType(),
            new Lexer\NotOrTokenType(),
            new Lexer\AndTokenType(),
            new Lexer\OrTokenType(),
            new Lexer\XorTokenType(),
            new Lexer\OpenParenthesisTokenType(),
            new Lexer\CloseParenthesisTokenType(),
            new Lexer\OpenSquareBracketTokenType(),
            new Lexer\NotOpenSquareBracketTokenType(),
            new Lexer\CloseSquareBracketTokenType(),
            new Lexer\DoubleOpenCurlyBracketTokenType(),
            new Lexer\NotDoubleOpenCurlyBracketTokenType(),
            new Lexer\DoubleCloseCurlyBracketTokenType(),
        ));
    }

    public function setInputSuccessDataProvider()
    {
        return array(
            array(
                ',',
                array(
                    array('value' => ',', 'type' => 'Symftony\Xpression\Lexer\CommaTokenType', 'position' => 0),
                ),
            ),
            array(
                '1.5',
                array(
                    array('value' => 1.5, 'type' => 'Symftony\Xpression\Lexer\FloatTokenType', 'position' => 0),
                ),
            ),
            array(
                '1',
                array(
                    array('value' => 1, 'type' => 'Symftony\Xpression\Lexer\IntegerTokenType', 'position' => 0),
                ),
            ),
            array(
                '\'value\'',
                array(
                    array('value' => 'value', 'type' => 'Symftony\Xpression\Lexer\StringTokenType', 'position' => 0),
                ),
            ),
            array(
                '"value"',
                array(
                    array('value' => 'value', 'type' => 'Symftony\Xpression\Lexer\StringTokenType', 'position' => 0),
                ),
            ),
            array(
                'str_ing.st-ring2',
                array(
                    array('value' => 'str_ing.st-ring2', 'type' => 'Symftony\Xpression\Lexer\InputParameterTokenType', 'position' => 0),
                ),
            ),
            array(
                '=≠>≥<≤',
                array(
                    array('value' => '=', 'type' => 'Symftony\Xpression\Lexer\EqualTokenType', 'position' => 0),
                    array('value' => '≠', 'type' => 'Symftony\Xpression\Lexer\NotEqualTokenType', 'position' => 1),
                    array('value' => '>', 'type' => 'Symftony\Xpression\Lexer\GreaterThanTokenType', 'position' => 4),
                    array('value' => '≥', 'type' => 'Symftony\Xpression\Lexer\GreaterThanEqualTokenType', 'position' => 5),
                    array('value' => '<', 'type' => 'Symftony\Xpression\Lexer\LowerThanTokenType', 'position' => 8),
                    array('value' => '≤', 'type' => 'Symftony\Xpression\Lexer\LowerThanEqualTokenType', 'position' => 9),
                ),
            ),
            array(
                '&!&|!|',
                array(
                    array('value' => '&', 'type' => 'Symftony\Xpression\Lexer\AndTokenType', 'position' => 0),
                    array('value' => '!&', 'type' => 'Symftony\Xpression\Lexer\NotAndTokenType', 'position' => 1),
                    array('value' => '|', 'type' => 'Symftony\Xpression\Lexer\OrTokenType', 'position' => 3),
                    array('value' => '!|', 'type' => 'Symftony\Xpression\Lexer\NotOrTokenType', 'position' => 4),
                ),
            ),
            array(
                '⊕^|',
                array(
                    array('value' => '⊕', 'type' => 'Symftony\Xpression\Lexer\XorTokenType', 'position' => 0),
                    array('value' => '⊕', 'type' => 'Symftony\Xpression\Lexer\XorTokenType', 'position' => 3),
                ),
            ),
            array(
                '()[![]{{!{{}}',
                array(
                    array('value' => '(', 'type' => 'Symftony\Xpression\Lexer\OpenParenthesisTokenType', 'position' => 0),
                    array('value' => ')', 'type' => 'Symftony\Xpression\Lexer\CloseParenthesisTokenType', 'position' => 1),
                    array('value' => '[', 'type' => 'Symftony\Xpression\Lexer\OpenSquareBracketTokenType', 'position' => 2),
                    array('value' => '![', 'type' => 'Symftony\Xpression\Lexer\NotOpenSquareBracketTokenType', 'position' => 3),
                    array('value' => ']', 'type' => 'Symftony\Xpression\Lexer\CloseSquareBracketTokenType', 'position' => 5),
                    array('value' => '{{', 'type' => 'Symftony\Xpression\Lexer\DoubleOpenCurlyBracketTokenType', 'position' => 6),
                    array('value' => '!{{', 'type' => 'Symftony\Xpression\Lexer\NotDoubleOpenCurlyBracketTokenType', 'position' => 8),
                    array('value' => '}}', 'type' => 'Symftony\Xpression\Lexer\DoubleCloseCurlyBracketTokenType', 'position' => 11),
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
                array('Symftony\Xpression\Lexer\CommaTokenType'),
                array(','),
            ),
            array(
                array('Symftony\Xpression\Lexer\FloatTokenType'),
                array('all float (.5 / 1.5 / -1.2e3)'),
            ),
            array(
                array('Symftony\Xpression\Lexer\IntegerTokenType'),
                array('all integer (1 / -2 / 03 / 0x1A / Ob101)'),
            ),
            array(
                array('Symftony\Xpression\Lexer\StringTokenType'),
                array('\'string\' or "string"'),
            ),
            array(
                array('Symftony\Xpression\Lexer\InputParameterTokenType'),
                array('string with . _ - and int (str_ing.st-ring2)'),
            ),
            array(
                array('Symftony\Xpression\Lexer\EqualTokenType'),
                array('='),
            ),
            array(
                array('Symftony\Xpression\Lexer\NotEqualTokenType'),
                array('≠ or !='),
            ),
            array(
                array('Symftony\Xpression\Lexer\GreaterThanTokenType'),
                array('>'),
            ),
            array(
                array('Symftony\Xpression\Lexer\GreaterThanEqualTokenType'),
                array('≥ or >='),
            ),
            array(
                array('Symftony\Xpression\Lexer\LowerThanTokenType'),
                array('<'),
            ),
            array(
                array('Symftony\Xpression\Lexer\LowerThanEqualTokenType'),
                array('≤ or <='),
            ),
            array(
                array('Symftony\Xpression\Lexer\NotAndTokenType'),
                array('!&'),
            ),
            array(
                array('Symftony\Xpression\Lexer\NotOrTokenType'),
                array('!|'),
            ),
            array(
                array('Symftony\Xpression\Lexer\AndTokenType'),
                array('&'),
            ),
            array(
                array('Symftony\Xpression\Lexer\OrTokenType'),
                array('|'),
            ),
            array(
                array('Symftony\Xpression\Lexer\XorTokenType'),
                array('⊕ or ^|'),
            ),
            array(
                array('Symftony\Xpression\Lexer\OpenParenthesisTokenType'),
                array('('),
            ),
            array(
                array('Symftony\Xpression\Lexer\CloseParenthesisTokenType'),
                array(')'),
            ),
            array(
                array('Symftony\Xpression\Lexer\OpenSquareBracketTokenType'),
                array('['),
            ),
            array(
                array('Symftony\Xpression\Lexer\NotOpenSquareBracketTokenType'),
                array('!['),
            ),
            array(
                array('Symftony\Xpression\Lexer\CloseSquareBracketTokenType'),
                array(']'),
            ),
            array(
                array('Symftony\Xpression\Lexer\DoubleOpenCurlyBracketTokenType'),
                array('{{'),
            ),
            array(
                array('Symftony\Xpression\Lexer\NotDoubleOpenCurlyBracketTokenType'),
                array('!{{'),
            ),
            array(
                array('Symftony\Xpression\Lexer\DoubleCloseCurlyBracketTokenType'),
                array('}}'),
            ),
        );
    }

    /**
     * @dataProvider getTokenSyntaxDataProvider
     *
     * @param $tokenTypes
     * @param $expectedTokenTypesSyntax
     */
    public function testGetTokenSyntax($tokenTypes, $expectedTokenTypesSyntax)
    {
        $this->assertEquals($expectedTokenTypesSyntax, $this->lexer->getTokenSyntax($tokenTypes));
    }
}
