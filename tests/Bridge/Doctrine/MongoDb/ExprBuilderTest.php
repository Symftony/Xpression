<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\MongoDb;

use Doctrine\MongoDB\Query\Expr;
use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\Doctrine\MongoDb\ExprBuilder;

class ExprBuilderTest extends TestCase
{
    /**
     * @var ExprBuilder
     */
    private $exprBuilder;

    public function setUp()
    {
        if (!class_exists('Doctrine\MongoDB\Query\Expr')) {
            $this->markTestSkipped('This test is run when you have "doctrine/mongodb-odm" installed.');
        }

        $this->exprBuilder = new ExprBuilder();
    }

    public function testIsNull()
    {
        $field = 'fake_field';
        $this->assertEquals(
            $this->createExpr()->field('fake_field')->equals(null),
            $this->exprBuilder->isNull($field)
        );
    }

    public function comparisonDataProvider()
    {
        if (!class_exists('Doctrine\MongoDB\Query\Expr')) {
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
            $this->createExpr()->field('field')->equals('value'),
            $this->exprBuilder->eq($field, $value)
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
            $this->createExpr()->field('field')->notEqual('value'),
            $this->exprBuilder->neq($field, $value)
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
            $this->createExpr()->field('field')->gt('value'),
            $this->exprBuilder->gt($field, $value)
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
            $this->createExpr()->field('field')->gte('value'),
            $this->exprBuilder->gte($field, $value)
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
            $this->createExpr()->field('field')->lt('value'),
            $this->exprBuilder->lt($field, $value)
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
            $this->createExpr()->field('field')->lte('value'),
            $this->exprBuilder->lte($field, $value)
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
            $this->createExpr()->field('field')->in(['value']),
            $this->exprBuilder->in($field, array($value))
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
            $this->createExpr()->field('field')->notIn(['value']),
            $this->exprBuilder->notIn($field, array($value))
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
        if (!class_exists('\MongoRegex')) {
            $this->markTestSkipped('This test need "\MongoRegex" installed.');
        }

        $this->assertEquals(
            $this->createExpr()->field('field')->equals(new \MongoRegex('/.*value.*/')),
            $this->exprBuilder->contains($field, $value)
        );
    }

    public function compositeDataProvider()
    {
        if (!class_exists('Doctrine\MongoDB\Query\Expr')) {
            return array();
        }

        return array(
            array(
                array(
                    array('fieldA' => 'value'),
                    array('fieldB' => array('$gt' => 2)),
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
            $this->createExpr()
                ->addAnd($this->createExpr()->field('fieldA')->equals('value'))
                ->addAnd($this->createExpr()->field('fieldB')->gt(2)),
            $this->exprBuilder->andX($expressions)
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
        $this->exprBuilder->nandX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param array $expressions
     */
    public function testOrX(array $expressions)
    {
        $this->assertEquals(
            $this->createExpr()
                ->addOr($this->createExpr()->field('fieldA')->equals('value'))
                ->addOr($this->createExpr()->field('fieldB')->gt(2)),
            $this->exprBuilder->orX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param array $expressions
     */
    public function testNorX(array $expressions)
    {
        $this->assertEquals(
            $this->createExpr()
                ->addNor($this->createExpr()->field('fieldA')->equals('value'))
                ->addNor($this->createExpr()->field('fieldB')->gt(2)),
            $this->exprBuilder->norX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     * @expectedException \Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException
     *
     * @param array $expressions
     */
    public function testXorX(array $expressions)
    {
        $this->exprBuilder->xorX($expressions);
    }

    private function createExpr()
    {
        return new Expr();
    }
}
