<?php

namespace Symftony\Xpression\Tests\Lexer;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Lexer\TokenTypeInterface;

abstract class TokenTypeTestCase extends TestCase
{
    /**
     * @var TokenTypeInterface
     */
    protected $tokenType;

    abstract public function catchablePatternsProvider();

    abstract public function getLiteralProvider();

    abstract public function supportValueProvider();

    /**
     * @dataProvider catchablePatternsProvider
     *
     * @param $expectedCatchablePatterns
     */
    public function testGetCatchablePatterns($expectedCatchablePatterns)
    {
        $this->assertSame($expectedCatchablePatterns, $this->tokenType->getCatchablePatterns());
    }

    /**
     * @dataProvider getLiteralProvider
     *
     * @param $expectedLiteral
     */
    public function testGetLiteral($expectedLiteral)
    {
        $this->assertSame($expectedLiteral, $this->tokenType->getLiteral());
    }

    /**
     * @dataProvider supportValueProvider
     *
     * @param $value
     * @param $expectedValue
     */
    public function testSupportValue($value, $expectedValue)
    {
        $this->assertTrue($this->tokenType->supportValue($value));
        $this->assertSame($expectedValue, $value);
    }
}
