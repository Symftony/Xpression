<?php

namespace Tests\Symftony\Xpression\Expr;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Expr\ClosureExpressionBuilder;
use Symftony\Xpression\Expr\HtmlExpressionBuilder;
use Symftony\Xpression\Lexer;

class HtmlExpressionBuilderTest extends TestCase
{
    /**
     * @var ClosureExpressionBuilder
     */
    private $closureExpressionBuilder;

    public function setUp(): void
    {
        $this->closureExpressionBuilder = new HtmlExpressionBuilder();
    }

    public function testGetSupportedTokenType()
    {
        $this->assertEquals(Lexer::T_ALL, $this->closureExpressionBuilder->getSupportedTokenType());
    }

    public function testParameter()
    {
        $this->assertEquals('my_fake_data', $this->closureExpressionBuilder->parameter('my_fake_data'));
        $this->assertEquals('my_fake_data', $this->closureExpressionBuilder->parameter('my_fake_data', true));
    }

    public function testString()
    {
        $this->assertEquals('"my_fake_data"', $this->closureExpressionBuilder->string('my_fake_data'));
    }

    public function isNullDataProvider()
    {
        return [
            ['field_null', '<div>field_null is null</div>'],
            ['field_number_5', '<div>field_number_5 is null</div>'],
        ];
    }

    /**
     * @dataProvider isNullDataProvider
     *
     * @param $field
     * @param $expectedResult
     */
    public function testIsNull($field, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->isNull($field)
        );
    }

    public function eqDataProvider()
    {
        return [
            ['field_number_5', 1, '<div>field_number_5 = 1</div>'],
            ['field_number_5', 5, '<div>field_number_5 = 5</div>'],
            ['field_number_5', 10, '<div>field_number_5 = 10</div>'],
        ];
    }

    /**
     * @dataProvider eqDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testEq($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->eq($field, $value)
        );
    }

    public function neqDataProvider()
    {
        return [
            ['field_number_5', 1, '<div>field_number_5 ≠ 1</div>'],
            ['field_number_5', 5, '<div>field_number_5 ≠ 5</div>'],
            ['field_number_5', 10, '<div>field_number_5 ≠ 10</div>'],
        ];
    }

    /**
     * @dataProvider neqDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testNeq($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->neq($field, $value)
        );
    }

    public function gtDataProvider()
    {
        return [
            ['field_number_5', 1, '<div>field_number_5 > 1</div>'],
            ['field_number_5', 5, '<div>field_number_5 > 5</div>'],
            ['field_number_5', 10, '<div>field_number_5 > 10</div>'],
        ];
    }

    /**
     * @dataProvider gtDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testGt($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->gt($field, $value)
        );
    }

    public function gteDataProvider()
    {
        return [
            ['field_number_5', 1, '<div>field_number_5 ≥ 1</div>'],
            ['field_number_5', 5, '<div>field_number_5 ≥ 5</div>'],
            ['field_number_5', 10, '<div>field_number_5 ≥ 10</div>'],
        ];
    }

    /**
     * @dataProvider gteDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testGte($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->gte($field, $value)
        );
    }

    public function ltDataProvider()
    {
        return [
            ['field_number_5', 1, '<div>field_number_5 < 1</div>'],
            ['field_number_5', 5, '<div>field_number_5 < 5</div>'],
            ['field_number_5', 10, '<div>field_number_5 < 10</div>'],
        ];
    }

    /**
     * @dataProvider ltDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testLt($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->lt($field, $value)
        );
    }

    public function lteDataProvider()
    {
        return [
            ['field_number_5', 1, '<div>field_number_5 ≤ 1</div>'],
            ['field_number_5', 5, '<div>field_number_5 ≤ 5</div>'],
            ['field_number_5', 10, '<div>field_number_5 ≤ 10</div>'],
        ];
    }

    /**
     * @dataProvider lteDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testLte($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->lte($field, $value)
        );
    }

    public function inDataProvider()
    {
        return [
            ['field_number_5', [1], '<div>field_number_5 value in 1</div>'],
            ['field_number_5', [1, 2, 3, 4, 5], '<div>field_number_5 value in 1, 2, 3, 4, 5</div>'],
        ];
    }

    /**
     * @dataProvider inDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testIn($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->in($field, $value)
        );
    }

    public function notInDataProvider()
    {
        return [
            ['field_number_5', [1], '<div>field_number_5 value not in 1</div>'],
            ['field_number_5', [1, 2, 3, 4, 5], '<div>field_number_5 value not in 1, 2, 3, 4, 5</div>'],
        ];
    }

    /**
     * @dataProvider notInDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testNotIn($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->notIn($field, $value)
        );
    }

    public function containsDataProvider()
    {
        return [
            ['field_string', 'toto', '<div>field_string contains toto</div>'],
            ['field_string', 'fake', '<div>field_string contains fake</div>'],
        ];
    }

    /**
     * @dataProvider containsDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testContains($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->contains($field, $value)
        );
    }

    public function notContainsDataProvider()
    {
        return [
            ['field_string', 'toto', '<div>field_string notContains toto</div>'],
            ['field_string', 'fake', '<div>field_string notContains fake</div>'],
        ];
    }

    /**
     * @dataProvider notContainsDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testNotContains($field, $value, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->notContains($field, $value)
        );
    }

    public function andXDataProvider()
    {
        return [
            [['false', 'false'], '<fieldset><legend>and</legend>falsefalse</fieldset>'],
            [['false', 'true'], '<fieldset><legend>and</legend>falsetrue</fieldset>'],
            [['true', 'false'], '<fieldset><legend>and</legend>truefalse</fieldset>'],
            [['true', 'true'], '<fieldset><legend>and</legend>truetrue</fieldset>'],
        ];
    }

    /**
     * @dataProvider andXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testAndX(array $expressions, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->andX($expressions)
        );
    }

    public function nandXDataProvider()
    {
        return [
            [['false', 'false'], '<fieldset><legend>not-and</legend>falsefalse</fieldset>'],
            [['false', 'true'], '<fieldset><legend>not-and</legend>falsetrue</fieldset>'],
            [['true', 'false'], '<fieldset><legend>not-and</legend>truefalse</fieldset>'],
            [['true', 'true'], '<fieldset><legend>not-and</legend>truetrue</fieldset>'],
        ];
    }

    /**
     * @dataProvider nandXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testNandX(array $expressions, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->nandX($expressions)
        );
    }

    public function orXDataProvider()
    {
        return [
            [['false', 'false'], '<fieldset><legend>or</legend>falsefalse</fieldset>'],
            [['false', 'true'], '<fieldset><legend>or</legend>falsetrue</fieldset>'],
            [['true', 'false'], '<fieldset><legend>or</legend>truefalse</fieldset>'],
            [['true', 'true'], '<fieldset><legend>or</legend>truetrue</fieldset>'],
        ];
    }

    /**
     * @dataProvider orXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testOrX(array $expressions, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->orX($expressions)
        );
    }

    public function norXDataProvider()
    {
        return [
            [['false', 'false'], '<fieldset><legend>not-or</legend>falsefalse</fieldset>'],
            [['false', 'true'], '<fieldset><legend>not-or</legend>falsetrue</fieldset>'],
            [['true', 'false'], '<fieldset><legend>not-or</legend>truefalse</fieldset>'],
            [['true', 'true'], '<fieldset><legend>not-or</legend>truetrue</fieldset>'],
        ];
    }

    /**
     * @dataProvider norXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testNorX(array $expressions, $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->norX($expressions)
        );
    }

    public function xorXDataProvider()
    {
        return [
            [['false', 'false'], '<fieldset><legend>exclusive-or</legend>falsefalse</fieldset>'],
            [['false', 'true'], '<fieldset><legend>exclusive-or</legend>falsetrue</fieldset>'],
            [['true', 'false'], '<fieldset><legend>exclusive-or</legend>truefalse</fieldset>'],
            [['true', 'true'], '<fieldset><legend>exclusive-or</legend>truetrue</fieldset>'],

            [['false', 'false', 'false'], '<fieldset><legend>exclusive-or</legend>falsefalsefalse</fieldset>'],
            [['false', 'false', 'true'], '<fieldset><legend>exclusive-or</legend>falsefalsetrue</fieldset>'],
            [['false', 'true', 'false'], '<fieldset><legend>exclusive-or</legend>falsetruefalse</fieldset>'],
            [['false', 'true', 'true'], '<fieldset><legend>exclusive-or</legend>falsetruetrue</fieldset>'],
            [['true', 'false', 'false'], '<fieldset><legend>exclusive-or</legend>truefalsefalse</fieldset>'],
            [['true', 'false', 'true'], '<fieldset><legend>exclusive-or</legend>truefalsetrue</fieldset>'],
            [['true', 'true', 'false'], '<fieldset><legend>exclusive-or</legend>truetruefalse</fieldset>'],
            [['true', 'true', 'true'], '<fieldset><legend>exclusive-or</legend>truetruetrue</fieldset>'],
        ];
    }

    /**
     * @dataProvider xorXDataProvider
     */
    public function testXorX(array $expressions, mixed $expectedResult)
    {
        $this->assertEquals(
            $expectedResult,
            $this->closureExpressionBuilder->xorX($expressions)
        );
    }
}
