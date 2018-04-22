<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\GreaterThanTokenType;

class GreaterThanTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new GreaterThanTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('>'),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('>'),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('>', '>'),
        );
    }
}
