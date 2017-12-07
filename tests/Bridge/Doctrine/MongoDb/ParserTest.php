<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\MongoDb;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\Doctrine\MongoDb\ExprBuilder;
use Symftony\Xpression\Parser;

class ParserTest extends TestCase
{
    /**
     * @var ExprBuilder
     */
    private $exprBuilder;

    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        if (!class_exists('Doctrine\MongoDB\Query\Expr')) {
            $this->markTestSkipped('This test is run when you have "doctrine/mongodb-odm" installed.');
        }

        $this->exprBuilder = new ExprBuilder();
        $this->parser = new Parser($this->exprBuilder);
    }

    public function parseSuccessDataProvider()
    {
        if (!class_exists('Doctrine\MongoDB\Query\Expr')) {
            return array();
        }

        return array(
            array(
                'fieldA=1',
                array('fieldA' => 1),
            ),
            array(
                'fieldA≥1',
                array('fieldA' => array('$gte' => 1)),
            ),
            array(
                'fieldA>=1',
                array('fieldA' => array('$gte' => 1)),
            ),
            array(
                'fieldA>1',
                array('fieldA' => array('$gt' => 1)),
            ),
            array(
                'fieldA≤1',
                array('fieldA' => array('$lte' => 1)),
            ),
            array(
                'fieldA<=1',
                array('fieldA' => array('$lte' => 1)),
            ),
            array(
                'fieldA<1',
                array('fieldA' => array('$lt' => 1)),
            ),
            array(
                'fieldA≠1',
                array('fieldA' => array('$ne' => 1)),
            ),
            array(
                'fieldA!=1',
                array('fieldA' => array('$ne' => 1)),
            ),
            array(
                'fieldA[1,2]',
                array('fieldA' => array('$in' => array(1, 2))),
            ),
            array(
                'fieldA![1,2]',
                array('fieldA' => array('$nin' => array(1, 2))),
            ),
            array(
                'fieldA=1|fieldB=2|fieldC=3',
                array('$or' => array(
                    array('fieldA' => 1),
                    array('fieldB' => 2),
                    array('fieldC' => 3),
                )),
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3',
                array('$and' => array(
                    array('fieldA' => 1),
                    array('fieldB' => 2),
                    array('fieldC' => 3),
                )),
            ),

            // Precedences
            array(
                'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
                array('$or' => array(
                    array('fieldA' => 1),
                    array('fieldB' => 2),
                    array('$and' => array(
                        array('fieldC' => 3),
                        array('fieldD' => 4)
                    )),
                )),
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
                array('$or' => array(
                    array('$and' => array(
                        array('fieldA' => 1),
                        array('fieldB' => 2),
                        array('fieldC' => 3),
                    )),
                    array('fieldD' => 4)
                )),
            ),
            array(
                'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
                array('$or' => array(
                    array('$and' => array(
                        array('fieldA' => 1),
                        array('fieldB' => 2),
                    )),
                    array('$and' => array(
                        array('fieldC' => 3),
                        array('fieldD' => 4)
                    ))
                )),
            ),

            //Parenthesis
            array(
                '((fieldA=1))',
                array('fieldA' => 1),
            ),
            array(
                '(fieldA=1|fieldB=2)&fieldC=3',
                array('$and' => array(
                    array('$or' => array(
                        array('fieldA' => 1),
                        array('fieldB' => 2),
                    )),
                    array('fieldC' => 3)
                )),
            ),
            array(
                'fieldA=1|(fieldB=2&fieldC=3)',
                array('$or' => array(
                    array('fieldA' => 1),
                    array('$and' => array(
                        array('fieldB' => 2),
                        array('fieldC' => 3)
                    ))
                )),
            ),
        );
    }

    /**
     * @dataProvider parseSuccessDataProvider
     *
     * @param $input
     * @param $expectedExpression
     */
    public function testParser($input, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->parser->parse($input)->getQuery());
    }

    public function unsupportedExpressionTypeDataProvider()
    {
        if (!class_exists('Doctrine\MongoDB\Query\Expr')) {
            return array();
        }

        return array(
            array('fieldA=1|fieldB=2|fieldC=3⊕fieldD=4'),
            array('fieldA=1^|fieldB=2'),
            array('fieldA=1⊕fieldB=2'),
            array('fieldA=1!&fieldB=2!&fieldC=3'),
            array('fieldA=1&fieldB=2&fieldC=3!&fieldD=4'),
        );
    }

    /**
     * @dataProvider unsupportedExpressionTypeDataProvider
     * @expectedException \Symftony\Xpression\Exception\Parser\InvalidExpressionException
     *
     * @param $input
     */
    public function testParserThrowUnsupportedExpressionTypeException($input)
    {
        $this->parser->parse($input);
    }
}
