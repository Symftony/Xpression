<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\CloseSquareBracketTokenType;

class CloseSquareBracketTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new CloseSquareBracketTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('\]'),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array(
                ']',
            ),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array(
                ']', ']',
            ),
        );
    }
}
