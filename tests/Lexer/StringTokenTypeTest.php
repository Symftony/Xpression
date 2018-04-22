<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\StringTokenType;

class StringTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new StringTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array(
                    "'(?:[^']|'')*'",
                    '"(?:[^"]|"")*"',
                ),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('\'string\' or "string"'),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('\'string\'', 'string'),
            array('"string"', 'string'),
        );
    }
}
