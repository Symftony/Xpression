<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;

class ExprAdapterTest extends TestCase
{
    /**
     * @var ExprAdapter
     */
    private $exprAdapter;

    public function setUp()
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            $this->markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }

        $this->exprAdapter = new ExprAdapter(new Expr());
    }

    public function testIsNull()
    {
        $field = 'fake_field';
        $this->assertEquals('fake_field IS NULL', $this->exprAdapter->isNull($field));
    }

    public function comparisonDataProvider()
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
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
            new Expr\Comparison($field, Expr\Comparison::EQ, $value),
            $this->exprAdapter->eq($field, $value)
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
            new Expr\Comparison($field, Expr\Comparison::NEQ, $value),
            $this->exprAdapter->neq($field, $value)
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
            new Expr\Comparison($field, Expr\Comparison::GT, $value),
            $this->exprAdapter->gt($field, $value)
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
            new Expr\Comparison($field, Expr\Comparison::GTE, $value),
            $this->exprAdapter->gte($field, $value)
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
            new Expr\Comparison($field, Expr\Comparison::LT, $value),
            $this->exprAdapter->lt($field, $value)
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
            new Expr\Comparison($field, Expr\Comparison::LTE, $value),
            $this->exprAdapter->lte($field, $value)
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
            new Expr\Func('field IN', array("'value'")),
            $this->exprAdapter->in($field, array($value))
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
            new Expr\Func('field NOT IN', array("'value'")),
            $this->exprAdapter->notIn($field, array($value))
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
            new Expr\Comparison('field', 'LIKE', $value),
            $this->exprAdapter->contains($field, $value)
        );
    }

    public function compositeDataProvider()
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return array();
        }

        return array(
            array(array(
                new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
            )),
            array(array(
                new Expr\Func('field', array('value'))
            )),
            array(array(
                new Expr\Andx(
                    array(
                        new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
                    )
                )
            )),
            array(array(
                new Expr\Orx(
                    array(
                        new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
                    )
                )
            )),
        );
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param $expressions
     */
    public function testAndX($expressions)
    {
        $this->assertEquals(
            new Expr\Andx($expressions),
            $this->exprAdapter->andX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     * @expectedException \Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException
     *
     * @param $expressions
     */
    public function testNandX($expressions)
    {
        $this->exprAdapter->nandX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param $expressions
     */
    public function testOrX($expressions)
    {
        $this->assertEquals(
            new Expr\Orx($expressions),
            $this->exprAdapter->orX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     * @expectedException \Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException
     *
     * @param $expressions
     */
    public function testNorX($expressions)
    {
        $this->exprAdapter->norX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     * @expectedException \Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException
     *
     * @param $expressions
     */
    public function testXorX($expressions)
    {
        $this->exprAdapter->xorX($expressions);
    }
}
