<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\NotDoubleOpenCurlyBracketTokenType;

class NotDoubleOpenCurlyBracketTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new NotDoubleOpenCurlyBracketTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('!{{'),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('!{{'),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('!{{', '!{{'),
        );
    }
}
