<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\InputParameterTokenType;

class InputParameterTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new InputParameterTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('[a-z_][a-z0-9_\.\-]*'),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('string with . _ - and int (str_ing.st-ring2)'),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('string', 'string'),
            array('str-ing', 'str-ing'),
            array('str_ing', 'str_ing'),
            array('str.ing', 'str.ing'),
            array('str1ng', 'str1ng'),
            array('a-', 'a-'),
            array('a_', 'a_'),
            array('a.', 'a.'),
            array('a1', 'a1'),
        );
    }
}
