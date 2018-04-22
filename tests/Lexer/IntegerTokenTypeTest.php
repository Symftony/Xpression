<?php

namespace Symftony\Xpression\Tests\Lexer;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Lexer\IntegerTokenType;

class IntegerTokenTypeTest extends TestCase
{
    public function catchablePatternsProvider()
    {
        return array(
            array(
                IntegerTokenType::ALLOW_NEGATIVE,
                array('(?:[+-]?(?:[1-9][0-9]*|0))'),
            ),
            array(
                IntegerTokenType::ALLOW_DECIMAL,
                array('(?:[1-9][0-9]*|0)'),
            ),
            array(
                IntegerTokenType::ALLOW_BINARY,
                array('(?:0b[01]+|[1-9][0-9]*|0)'),
            ),
            array(
                IntegerTokenType::ALLOW_HEXADECIMAL,
                array('(?:0[xX][0-9a-fA-F]+|[1-9][0-9]*|0)'),
            ),
            array(
                IntegerTokenType::ALLOW_OCTAL,
                array('(?:0[0-7]+|[1-9][0-9]*|0)'),
            ),
            array(
                IntegerTokenType::ALLOW_ALL,
                array('(?:[+-]?(?:0b[01]+|0[xX][0-9a-fA-F]+|0[0-7]+|[1-9][0-9]*|0))'),
            ),
        );
    }

    /**
     * @dataProvider catchablePatternsProvider
     *
     * @param $allowedFormats
     * @param $expectedCatchablePatterns
     */
    public function testGetCatchablePatterns($allowedFormats, $expectedCatchablePatterns)
    {
        $integerTokenType = new IntegerTokenType($allowedFormats);

        $this->assertSame($expectedCatchablePatterns, $integerTokenType->getCatchablePatterns());
    }

    public function getLiteralProvider()
    {
        return array(
            array(
                IntegerTokenType::ALLOW_NEGATIVE,
                'signed integer (1)',
            ),
            array(
                IntegerTokenType::ALLOW_DECIMAL,
                'integer (1)',
            ),
            array(
                IntegerTokenType::ALLOW_BINARY,
                'integer (1 / 0b101)',
            ),
            array(
                IntegerTokenType::ALLOW_HEXADECIMAL,
                'integer (1 / 0x1A)',
            ),
            array(
                IntegerTokenType::ALLOW_OCTAL,
                'integer (1 / 03)',
            ),
            array(
                IntegerTokenType::ALLOW_ALL,
                'signed integer (1 / 0b101 / 0x1A / 03)',
            ),
        );
    }

    /**
     * @dataProvider getLiteralProvider
     *
     * @param $allowedFormats
     * @param $expectedLiteral
     */
    public function testGetLiteral($allowedFormats, $expectedLiteral)
    {
        $integerTokenType = new IntegerTokenType($allowedFormats);

        $this->assertSame($expectedLiteral, $integerTokenType->getLiteral());
    }

    public function supportValueProvider()
    {
        return array(
            array('11', 11),
            array('-11', -11),
            array('011', 9),
            array('-011', -9),
            array('0x1A', 26),
            array('-0x1A', -26),
            array('0b101', 5),
            array('-0b101', -5),
        );
    }

    /**
     * @dataProvider supportValueProvider
     *
     * @param $value
     * @param $expectedValue
     */
    public function testSupportValue($value, $expectedValue)
    {
        $integerTokenType = new IntegerTokenType();

        $this->assertTrue($integerTokenType->supportValue($value));
        $this->assertSame($expectedValue, $value);
    }

    public function notSupportValueProvider()
    {
        return array(
            array(IntegerTokenType::ALLOW_ALL - IntegerTokenType::ALLOW_HEXADECIMAL, '0x1A'),
            array(IntegerTokenType::ALLOW_ALL - IntegerTokenType::ALLOW_HEXADECIMAL, '-0x1A'),
            array(IntegerTokenType::ALLOW_ALL - IntegerTokenType::ALLOW_BINARY, '0b101'),
            array(IntegerTokenType::ALLOW_ALL - IntegerTokenType::ALLOW_BINARY, '-0b101'),
        );
    }

    /**
     * @dataProvider notSupportValueProvider
     *
     * @param $allowedFormat
     * @param $value
     */
    public function testNotSupportValue($allowedFormat, $value)
    {
        $integerTokenType = new IntegerTokenType($allowedFormat);

        $this->assertFalse($integerTokenType->supportValue($value));
    }
}
