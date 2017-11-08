<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Parser;

class ParserTest extends TestCase
{
    /**
     * @var ExprAdapter
     */
    private $exprAdapter;

    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            $this->markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }
        $this->exprAdapter = new ExprAdapter(new Expr());
        $this->parser = new Parser($this->exprAdapter);
    }

    public function parseSuccessDataProvider()
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return array();
        }

        return array(
            array(
                'fieldA=1',
                new Expr\Comparison('fieldA', '=', 1),
            ),
            array(
                'fieldA≥1',
                new Expr\Comparison('fieldA', '>=', 1),
            ),
            array(
                'fieldA>=1',
                new Expr\Comparison('fieldA', '>=', 1),
            ),
            array(
                'fieldA≤1',
                new Expr\Comparison('fieldA', '<=', 1),
            ),
            array(
                'fieldA<=1',
                new Expr\Comparison('fieldA', '<=', 1),
            ),
            array(
                'fieldA≠1',
                new Expr\Comparison('fieldA', '<>', 1),
            ),
            array(
                'fieldA!=1',
                new Expr\Comparison('fieldA', '<>', 1),
            ),
            array(
                'fieldA[1,2]',
                new Expr\Func('fieldA IN', array(1, 2)),
            ),
            array(
                'fieldA![1,2]',
                new Expr\Func('fieldA NOT IN', array(1, 2)),
            ),
            array(
                'fieldA=1|fieldB=2|fieldC=3',
                new Expr\Orx(array(
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                    new Expr\Comparison('fieldC', '=', 3),
                )),
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3',
                new Expr\Andx(array(
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                    new Expr\Comparison('fieldC', '=', 3),
                )),
            ),

            // Precedences
            array(
                'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
                new Expr\Orx(array(
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                    new Expr\Andx(array(
                        new Expr\Comparison('fieldC', '=', 3),
                        new Expr\Comparison('fieldD', '=', 4),
                    )),
                )),
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
                new Expr\Orx(array(
                    new Expr\Andx(array(
                        new Expr\Comparison('fieldA', '=', 1),
                        new Expr\Comparison('fieldB', '=', 2),
                        new Expr\Comparison('fieldC', '=', 3),
                    )),
                    new Expr\Comparison('fieldD', '=', 4),
                )),
            ),
            array(
                'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
                new Expr\Orx(array(
                    new Expr\Andx(array(
                        new Expr\Comparison('fieldA', '=', 1),
                        new Expr\Comparison('fieldB', '=', 2),
                    )),
                    new Expr\Andx(array(
                        new Expr\Comparison('fieldC', '=', 3),
                        new Expr\Comparison('fieldD', '=', 4),
                    )),
                )),
            ),

            //Parenthesis
            array(
                '((fieldA=1))',
                new Expr\Comparison('fieldA', '=', 1),
            ),
            array(
                '(fieldA=1|fieldB=2)&fieldC=3',
                new Expr\Andx(array(
                    new Expr\Orx(array(
                        new Expr\Comparison('fieldA', '=', 1),
                        new Expr\Comparison('fieldB', '=', 2),
                    )),
                    new Expr\Comparison('fieldC', '=', 3),
                )),
            ),
            array(
                'fieldA=1|(fieldB=2&fieldC=3)',
                new Expr\Orx(array(
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Andx(array(
                        new Expr\Comparison('fieldB', '=', 2),
                        new Expr\Comparison('fieldC', '=', 3),
                    )),
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
        $this->assertEquals($expectedExpression, $this->parser->parse($input));
    }

    public function unsupportedExpressionTypeDataProvider()
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return array();
        }

        return array(
            array('fieldA=1!|fieldB=2!|fieldC=3'),
            array('fieldA=1^|fieldB=2'),
            array('fieldA=1⊕fieldB=2'),
            array('fieldA=1!&fieldB=2!&fieldC=3'),
            array('fieldA=1&fieldB=2&fieldC=3!&fieldD=4'),
            array('fieldA=1|fieldB=2|fieldC=3!|fieldD=4'),
            array('fieldA=1|fieldB=2|fieldC=3⊕fieldD=4'),
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
