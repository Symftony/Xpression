<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\NotOrTokenType;

class NotOrTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new NotOrTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('!\|'),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('!|'),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('!|', '!|'),
        );
    }
}
