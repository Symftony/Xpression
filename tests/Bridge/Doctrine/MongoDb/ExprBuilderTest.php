<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\MongoDb;

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
            array('fake_field' => null),
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
            array('field' => 'value'),
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
            array('field' => array('$ne' => 'value')),
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
            array('field' => array('$gt' => 'value')),
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
            array('field' => array('$gte' => 'value')),
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
            array('field' => array('$lt' => 'value')),
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
            array('field' => array('$lte' => 'value')),
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
            array('field' => array('$in' => array('value'))),
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
            array('field' => array('$nin' => array('value'))),
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
            array('field' => new \MongoRegex('/.*value.*/')),
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
            array('$and' => array(
                array('fieldA' => 'value'),
                array('fieldB' => array('$gt' => 2)),
            )),
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
            array('$or' => array(
                array('fieldA' => 'value'),
                array('fieldB' => array('$gt' => 2)),
            )),
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
            array('$nor' => array(
                array('fieldA' => 'value'),
                array('fieldB' => array('$gt' => 2)),
            )),
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
}
