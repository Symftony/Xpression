<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\FloatTokenType;

class FloatTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new FloatTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('(?:[+-]?(?:(?:(?:[0-9]+|(?:[0-9]*[\.][0-9]+)|(?:[0-9]+[\.][0-9]*))[eE][+-]?[0-9]+)|(?:[0-9]*[\.][0-9]+)|(?:[0-9]+[\.][0-9]*)))'),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array(
                'all float (.5 / 1.5 / -1.2e3)',
            ),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array(
                '.1', .1,
            ),
            array(
                '-.1', -.1,
            ),
            array(
                '1.1', 1.1,
            ),
            array(
                '-1.1', -1.1,
            ),
            array(
                '1.1e3', 1100.0,
            ),
            array(
                '-1.1e3', -1100.0,
            ),
        );
    }
}
