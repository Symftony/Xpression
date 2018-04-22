<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\LowerThanTokenType;

class LowerThanTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new LowerThanTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('<'),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('<'),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('<', '<'),
        );
    }
}
