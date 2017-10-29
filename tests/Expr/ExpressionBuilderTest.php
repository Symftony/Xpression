<?php

namespace Tests\Symftony\Xpression;

use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Expr\ExpressionBuilderAdapter;

class ExpressionBuilderAdapterTest extends TestCase
{
    /**
     * @var ExpressionBuilderAdapter
     */
    private $expressionBuilderAdapter;

    public function setUp()
    {
        $this->expressionBuilderAdapter = new ExpressionBuilderAdapter(new ExpressionBuilder());
    }

    public function parseSuccessDataProvider()
    {
        return array(
            array(
                'fieldA=1',
                new Comparison('fieldA', '=', 1),
            ),
            array(
                'fieldA≥1',
                new Comparison('fieldA', '>=', 1),
            ),
            array(
                'fieldA>=1',
                new Comparison('fieldA', '>=', 1),
            ),
            array(
                'fieldA≤1',
                new Comparison('fieldA', '<=', 1),
            ),
            array(
                'fieldA<=1',
                new Comparison('fieldA', '<=', 1),
            ),
            array(
                'fieldA≠1',
                new Comparison('fieldA', '<>', 1),
            ),
            array(
                'fieldA!=1',
                new Comparison('fieldA', '<>', 1),
            ),
            array(
                'fieldA[1,2]',
                new Comparison('fieldA', 'IN', array(1, 2)),
            ),
            array(
                'fieldA![1,2]',
                new Comparison('fieldA', 'NIN', array(1, 2)),
            ),
            array(
                'fieldA=1|fieldB=2|fieldC=3',
                new CompositeExpression('OR', array(
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                    new Comparison('fieldC', '=', 3),
                )),
            ),
            array(
                'fieldA=1!|fieldB=2!|fieldC=3',
                new CompositeExpression('NOR', array(
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                    new Comparison('fieldC', '=', 3),
                )),
            ),
            array(
                'fieldA=1^|fieldB=2',
                new CompositeExpression('XOR', array(
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                )),
            ),
            array(
                'fieldA=1⊕fieldB=2',
                new CompositeExpression('XOR', array(
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                )),
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3',
                new CompositeExpression('AND', array(
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                    new Comparison('fieldC', '=', 3),
                )),
            ),
            array(
                'fieldA=1!&fieldB=2!&fieldC=3',
                new CompositeExpression('NAND', array(
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                    new Comparison('fieldC', '=', 3),
                )),
            ),

            // Precedences
            array(
                'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
                new CompositeExpression('OR', array(
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                    new CompositeExpression('AND', array(
                        new Comparison('fieldC', '=', 3),
                        new Comparison('fieldD', '=', 4),
                    )),
                )),
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3!&fieldD=4',
                new CompositeExpression('NAND', array(
                    new CompositeExpression('AND', array(
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                        new Comparison('fieldC', '=', 3),
                    )),
                    new Comparison('fieldD', '=', 4),
                )),
            ),
            array(
                'fieldA=1|fieldB=2|fieldC=3!|fieldD=4',
                new CompositeExpression('NOR', array(
                    new CompositeExpression('OR', array(
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                        new Comparison('fieldC', '=', 3),
                    )),
                    new Comparison('fieldD', '=', 4),
                )),
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
                new CompositeExpression('OR', array(
                    new CompositeExpression('AND', array(
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                        new Comparison('fieldC', '=', 3),
                    )),
                    new Comparison('fieldD', '=', 4),
                )),
            ),
            array(
                'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
                new CompositeExpression('OR', array(
                    new CompositeExpression('AND', array(
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                    )),
                    new CompositeExpression('AND', array(
                        new Comparison('fieldC', '=', 3),
                        new Comparison('fieldD', '=', 4),
                    )),
                )),
            ),
            array(
                'fieldA=1|fieldB=2|fieldC=3⊕fieldD=4',
                new CompositeExpression('XOR', array(
                    new CompositeExpression('OR', array(
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                        new Comparison('fieldC', '=', 3),
                    )),
                    new Comparison('fieldD', '=', 4),
                )),
            ),

            //Parenthesis
            array(
                '((fieldA=1))',
                new Comparison('fieldA', '=', 1),
            ),
            array(
                '(fieldA=1|fieldB=2)&fieldC=3',
                new CompositeExpression('AND', array(
                    new CompositeExpression('OR', array(
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                    )),
                    new Comparison('fieldC', '=', 3),
                )),
            ),
            array(
                'fieldA=1|(fieldB=2&fieldC=3)',
                new CompositeExpression('OR', array(
                    new Comparison('fieldA', '=', 1),
                    new CompositeExpression('AND', array(
                        new Comparison('fieldB', '=', 2),
                        new Comparison('fieldC', '=', 3),
                    )),
                )),
            ),
        );
    }

    public function eqDataProvider()
    {
        return array(
            array(
                'fieldA',
                1,
                new Comparison('fieldA', '=', 1),
            ),
        );
    }

    /**
     * @dataProvider eqDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testEq($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->eq($field, $value));
    }

    public function neqDataProvider()
    {
        return array(
            array(
                'fieldA',
                1,
                new Comparison('fieldA', '<>', 1),
            ),
        );
    }

    /**
     * @dataProvider neqDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testNeq($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->neq($field, $value));
    }

    public function gtDataProvider()
    {
        return array(
            array(
                'fieldA',
                1,
                new Comparison('fieldA', '>', 1),
            ),
        );
    }

    /**
     * @dataProvider gtDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testGt($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->gt($field, $value));
    }

    public function gteDataProvider()
    {
        return array(
            array(
                'fieldA',
                1,
                new Comparison('fieldA', '>=', 1),
            ),
        );
    }

    /**
     * @dataProvider gteDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testGte($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->gte($field, $value));
    }

    public function ltDataProvider()
    {
        return array(
            array(
                'fieldA',
                1,
                new Comparison('fieldA', '<', 1),
            ),
        );
    }

    /**
     * @dataProvider ltDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testLt($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->lt($field, $value));
    }

    public function lteDataProvider()
    {
        return array(
            array(
                'fieldA',
                1,
                new Comparison('fieldA', '<=', 1),
            ),
        );
    }

    /**
     * @dataProvider lteDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testLte($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->lte($field, $value));
    }

    public function testIsNull()
    {
        $this->assertEquals(new Comparison('fieldA', '=', null), $this->expressionBuilderAdapter->isNull('fieldA'));
    }

    public function inDataProvider()
    {
        return array(
            array(
                'fieldA',
                array(1),
                new Comparison('fieldA', 'IN', array(1)),
            ),
        );
    }

    /**
     * @dataProvider inDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testIn($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->in($field, $value));
    }

    public function notInDataProvider()
    {
        return array(
            array(
                'fieldA',
                array(1),
                new Comparison('fieldA', 'NIN', array(1)),
            ),
        );
    }

    /**
     * @dataProvider notInDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testNotIn($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->notIn($field, $value));
    }

    public function containsDataProvider()
    {
        return array(
            array(
                'fieldA',
                1,
                new Comparison('fieldA', 'CONTAINS', 1),
            ),
        );
    }

    /**
     * @dataProvider containsDataProvider
     *
     * @param $field
     * @param $value
     * @param $expectedExpression
     */
    public function testContains($field, $value, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->contains($field, $value));
    }
    
    public function andXDataProvider()
    {
        $expressionA = new Comparison('fieldA', '=', 1);
        $expressionB = new Comparison('fieldB', '>', 2);
        return array(
            array(
                array($expressionA, $expressionB),
                new CompositeExpression('AND', array($expressionA, $expressionB)),
            ),
        );
    }

    /**
     * @dataProvider andXDataProvider
     *
     * @param array $expressions
     * @param $expectedExpression
     */
    public function testAndX(array $expressions, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->andX($expressions));
    }

    public function nandXDataProvider()
    {
        $expressionA = new Comparison('fieldA', '=', 1);
        $expressionB = new Comparison('fieldB', '>', 2);
        return array(
            array(
                array($expressionA, $expressionB),
                new CompositeExpression('NAND', array($expressionA, $expressionB)),
            ),
        );
    }

    /**
     * @dataProvider nandXDataProvider
     *
     * @param array $expressions
     * @param $expectedExpression
     */
    public function testNandX(array $expressions, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->nandX($expressions));
    }

    public function orXDataProvider()
    {
        $expressionA = new Comparison('fieldA', '=', 1);
        $expressionB = new Comparison('fieldB', '>', 2);
        return array(
            array(
                array($expressionA, $expressionB),
                new CompositeExpression('OR', array($expressionA, $expressionB)),
            ),
        );
    }

    /**
     * @dataProvider orXDataProvider
     *
     * @param array $expressions
     * @param $expectedExpression
     */
    public function testOrX(array $expressions, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->orX($expressions));
    }

    public function norXDataProvider()
    {
        $expressionA = new Comparison('fieldA', '=', 1);
        $expressionB = new Comparison('fieldB', '>', 2);
        return array(
            array(
                array($expressionA, $expressionB),
                new CompositeExpression('NOR', array($expressionA, $expressionB)),
            ),
        );
    }

    /**
     * @dataProvider norXDataProvider
     *
     * @param array $expressions
     * @param $expectedExpression
     */
    public function testNorX(array $expressions, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->norX($expressions));
    }

    public function xorXDataProvider()
    {
        $expressionA = new Comparison('fieldA', '=', 1);
        $expressionB = new Comparison('fieldB', '>', 2);
        return array(
            array(
                array($expressionA, $expressionB),
                new CompositeExpression('XOR', array($expressionA, $expressionB)),
            ),
        );
    }

    /**
     * @dataProvider xorXDataProvider
     *
     * @param array $expressions
     * @param $expectedExpression
     */
    public function testXorX(array $expressions, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->expressionBuilderAdapter->xorX($expressions));
    }
}
