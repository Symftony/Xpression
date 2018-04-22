<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\GreaterThanEqualTokenType;

class GreaterThanEqualTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new GreaterThanEqualTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('≥', '>='),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('≥ or >='),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('>=', '≥'),
            array('≥', '≥'),
        );
    }
}
