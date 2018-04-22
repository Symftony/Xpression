<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\XorTokenType;

class XorTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new XorTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('⊕', '\^\|'),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('⊕ or ^|'),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('^|', '⊕'),
            array('⊕', '⊕'),
        );
    }
}
