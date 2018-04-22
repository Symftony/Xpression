<?php

namespace Symftony\Xpression\Tests\Lexer;

use Symftony\Xpression\Lexer\LowerThanEqualTokenType;

class LowerThanEqualTokenTypeTest extends TokenTypeTestCase
{
    public function setUp()
    {
        $this->tokenType = new LowerThanEqualTokenType();
    }

    public function catchablePatternsProvider()
    {
        return array(
            array(
                array('≤', '<='),
            ),
        );
    }

    public function getLiteralProvider()
    {
        return array(
            array('≤ or <='),
        );
    }

    public function supportValueProvider()
    {
        return array(
            array('<=', '≤'),
            array('≤', '≤'),
        );
    }
}
