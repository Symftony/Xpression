<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\Common;

use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;

class ExpressionBuilderAdapterTest extends TestCase
{
    /**
     * @var ExpressionBuilderAdapter
     */
    private $expressionBuilderAdapter;

    public function setUp()
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            $this->markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }

        $this->expressionBuilderAdapter = new ExpressionBuilderAdapter(new ExpressionBuilder());
    }

    public function testIsNull()
    {
        $field = 'fake_field';
        $this->assertEquals(
            new Comparison('fake_field', '=', null),
            $this->expressionBuilderAdapter->isNull($field)
        );
    }

    public function comparisonDataProvider()
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            return array();
        }

        return array(
            array('field', 'value'),
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testEq($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', '=', 'value'),
            $this->expressionBuilderAdapter->eq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testNeq($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', '<>', 'value'),
            $this->expressionBuilderAdapter->neq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testGt($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', '>', 'value'),
            $this->expressionBuilderAdapter->gt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testGte($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', '>=', 'value'),
            $this->expressionBuilderAdapter->gte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testLt($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', '<', 'value'),
            $this->expressionBuilderAdapter->lt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testLte($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', '<=', 'value'),
            $this->expressionBuilderAdapter->lte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testIn($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', 'IN', array('value')),
            $this->expressionBuilderAdapter->in($field, array($value))
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testNotIn($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', 'NIN', array('value')),
            $this->expressionBuilderAdapter->notIn($field, array($value))
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     *
     * @param $field
     * @param $value
     */
    public function testContains($field, $value)
    {
        $this->assertEquals(
            new Comparison('field', 'CONTAINS', 'value'),
            $this->expressionBuilderAdapter->contains($field, $value)
        );
    }

    public function compositeDataProvider()
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            return array();
        }

        return array(
            array(
                array(
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '>', 2)
                ),
            ),
        );
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param array $expressions
     */
    public function testAndX(array $expressions)
    {
        $this->assertEquals(
            new CompositeExpression('AND', $expressions),
            $this->expressionBuilderAdapter->andX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     * @expectedException \Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException
     *
     * @param array $expressions
     */
    public function testNandX(array $expressions)
    {
        $this->expressionBuilderAdapter->nandX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param array $expressions
     */
    public function testOrX(array $expressions)
    {
        $this->assertEquals(
            new CompositeExpression('OR', $expressions),
            $this->expressionBuilderAdapter->orX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     * @expectedException \Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException
     *
     * @param array $expressions
     */
    public function testNorX(array $expressions)
    {
        $this->expressionBuilderAdapter->norX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     * @expectedException \Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException
     *
     * @param array $expressions
     */
    public function testXorX(array $expressions)
    {
        $this->expressionBuilderAdapter->xorX($expressions);
    }
}
