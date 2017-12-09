<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\Common;

use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
use Symftony\Xpression\Parser;

class ParserTest extends TestCase
{
    /**
     * @var ExpressionBuilderAdapter
     */
    private $expressionBuilderAdapter;

    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            $this->markTestSkipped('This test is run when you have "doctrine/collection" installed.');
        }

        $this->expressionBuilderAdapter = new ExpressionBuilderAdapter(new ExpressionBuilder());
        $this->parser = new Parser($this->expressionBuilderAdapter);
    }

    public function parseSuccessDataProvider()
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            return array();
        }

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
                'fieldA=1&fieldB=2&fieldC=3',
                new CompositeExpression('AND', array(
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
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            return array();
        }

        return array(
            array('fieldA=1|fieldB=2|fieldC=3⊕fieldD=4'),
            array('fieldA=1!|fieldB=2!|fieldC=3'),
            array('fieldA=1^|fieldB=2'),
            array('fieldA=1⊕fieldB=2'),
            array('fieldA=1!&fieldB=2!&fieldC=3'),
            array('fieldA=1&fieldB=2&fieldC=3!&fieldD=4'),
            array('fieldA=1|fieldB=2|fieldC=3!|fieldD=4'),
            array('fieldA!{{1}}'),
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
