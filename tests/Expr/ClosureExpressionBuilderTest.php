<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\Common;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Expr\ClosureExpressionBuilder;

class ClosureExpressionBuilderTest extends TestCase
{
    /**
     * @var array
     */
    private $exampleData;

    /**
     * @var ClosureExpressionBuilder
     */
    private $closureExpressionBuilder;

    public function setUp()
    {
        $this->exampleData = array(
            'field_null' => null,
            'field_number_5' => 5,
            'field_number_10' => 10,
            'field_string' => 'my_fake_string',
        );
        $this->closureExpressionBuilder = new ClosureExpressionBuilder();
    }

    public function isNullDataProvider()
    {
        return array(
            array('field_null', true),
            array('field_number_5', false),
        );
    }

    /**
     * @dataProvider isNullDataProvider
     *
     * @param $field
     * @param $expectedResult
     */
    public function testIsNull($field, $expectedResult)
    {
        $expression = $this->closureExpressionBuilder->isNull($field);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function eqDataProvider()
    {
        return array(
            array('field_number_5', 1, false),
            array('field_number_5', 5, true),
            array('field_number_5', 10, false),
        );
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
        $expression = $this->closureExpressionBuilder->eq($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function neqDataProvider()
    {
        return array(
            array('field_number_5', 1, true),
            array('field_number_5', 5, false),
            array('field_number_5', 10, true),
        );
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
        $expression = $this->closureExpressionBuilder->neq($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function gtDataProvider()
    {
        return array(
            array('field_number_5', 1, true),
            array('field_number_5', 5, false),
            array('field_number_5', 10, false),
        );
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
        $expression = $this->closureExpressionBuilder->gt($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function gteDataProvider()
    {
        return array(
            array('field_number_5', 1, true),
            array('field_number_5', 5, true),
            array('field_number_5', 10, false),
        );
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
        $expression = $this->closureExpressionBuilder->gte($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function ltDataProvider()
    {
        return array(
            array('field_number_5', 1, false),
            array('field_number_5', 5, false),
            array('field_number_5', 10, true),
        );
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
        $expression = $this->closureExpressionBuilder->lt($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function lteDataProvider()
    {
        return array(
            array('field_number_5', 1, false),
            array('field_number_5', 5, true),
            array('field_number_5', 10, true),
        );
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
        $expression = $this->closureExpressionBuilder->lte($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function inDataProvider()
    {
        return array(
            array('field_number_5', array(1), false),
            array('field_number_5', array(1, 2, 3, 4, 5), true),
        );
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
        $expression = $this->closureExpressionBuilder->in($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    /**
     * @dataProvider inDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testNotIn($field, $value, $expectedResult)
    {
        $expression = $this->closureExpressionBuilder->notIn($field, $value);
        $this->assertEquals(
            !$expectedResult,
            $expression($this->exampleData)
        );
    }

    public function containsDataProvider()
    {
        return array(
            array('field_string', 'toto', false),
            array('field_string', 'fake', true),
        );
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
        $expression = $this->closureExpressionBuilder->contains($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    /**
     * @dataProvider containsDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedResult
     */
    public function testNotContains($field, $value, $expectedResult)
    {
        $expression = $this->closureExpressionBuilder->notContains($field, $value);
        $this->assertEquals(
            !$expectedResult,
            $expression($this->exampleData)
        );
    }

    public function andXDataProvider()
    {
        return array(
            array(array(false, false), false),
            array(array(false, true), false),
            array(array(true, false), false),
            array(array(true, true), true),
        );
    }

    /**
     * @dataProvider andXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testAndX(array $expressions, $expectedResult)
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->andX($expressionsCallable);
        $this->assertEquals(
            $expectedResult,
            $expression('useless_data')
        );
    }

    /**
     * @dataProvider andXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testNandX(array $expressions, $expectedResult)
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->nandX($expressionsCallable);
        $this->assertEquals(
            !$expectedResult,
            $expression('useless_data')
        );
    }

    public function orXDataProvider()
    {
        return array(
            array(array(false, false), false),
            array(array(false, true), true),
            array(array(true, false), true),
            array(array(true, true), true),
        );
    }

    /**
     * @dataProvider orXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testOrX(array $expressions, $expectedResult)
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->orX($expressionsCallable);
        $this->assertEquals(
            $expectedResult,
            $expression('useless_data')
        );
    }

    /**
     * @dataProvider orXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testNorX(array $expressions, $expectedResult)
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->norX($expressionsCallable);
        $this->assertEquals(
            !$expectedResult,
            $expression('useless_data')
        );
    }

    public function xorXDataProvider()
    {
        return array(
            array(array(false, false), false),
            array(array(false, true), true),
            array(array(true, false), true),
            array(array(true, true), false),

            array(array(false, false, false), false),
            array(array(false, false, true), true),
            array(array(false, true, false), true),
            array(array(false, true, true), false),
            array(array(true, false, false), true),
            array(array(true, false, true), false),
            array(array(true, true, false), false),
            array(array(true, true, true), true),
        );
    }

    /**
     * @dataProvider xorXDataProvider
     *
     * @param array $expressions
     * @param $expectedResult
     */
    public function testXorX(array $expressions, $expectedResult)
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->xorX($expressionsCallable);
        $this->assertEquals(
            $expectedResult,
            $expression('useless_data')
        );
    }
}
