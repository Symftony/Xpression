<?php

namespace Tests\Symftony\Xpression;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Lexer;
use Symftony\Xpression\Parser;

class ParserTest extends TestCase
{
    /**
     * @var ExpressionBuilderInterface|ObjectProphecy
     */
    private $expressionBuilderMock;

    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        $this->expressionBuilderMock = $this->prophesize('Symftony\Xpression\Expr\ExpressionBuilderInterface');
        $this->expressionBuilderMock->getSupportedTokenType()->willReturn(Lexer::T_ALL);

        $this->parser = new Parser($this->expressionBuilderMock->reveal());
    }

    public function parseSuccessDataProvider()
    {
        return array(
            array(
                'fieldA=1',
                array(array('eq', 'fieldA', 1, 'my_fake_comparison_A')),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA>1',
                array(array('gt', 'fieldA', 1, 'my_fake_comparison_A')),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA≥1',
                array(
                    array('gte', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA>=1',
                array(
                    array('gte', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA<1',
                array(
                    array('lt', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA≤1',
                array(
                    array('lte', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA<=1',
                array(
                    array('lte', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA≠1',
                array(
                    array('neq', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA!=1',
                array(
                    array('neq', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA[1,2]',
                array(
                    array('in', 'fieldA', array(1, 2), 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA![1,2]',
                array(
                    array('notIn', 'fieldA', array(1, 2), 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A'
            ),
            array(
                'fieldA{{1}}',
                array(
                    array('contains', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A',
            ),
            array(
                'fieldA!{{1}}',
                array(
                    array('notContains', 'fieldA', 1, 'my_fake_comparison_A')
                ),
                array(),
                'my_fake_comparison_A'
            ),

            // Composite
            array(
                'fieldA=1|fieldB=2|fieldC=3',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                ),
                array(
                    array('orX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_orX_composite'),
                ),
                'my_fake_orX_composite'
            ),
            array(
                'fieldA=1!|fieldB=2!|fieldC=3',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                ),
                array(
                    array('norX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_norX_composite'),
                ),
                'my_fake_norX_composite'
            ),
            array(
                'fieldA=1^|fieldB=2^|fieldC=3',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                ),
                array(
                    array('xorX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_xorX_composite'),
                ),
                'my_fake_xorX_composite'
            ),
            array(
                'fieldA=1⊕fieldB=2⊕fieldC=3',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                ),
                array(
                    array('xorX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_xorX_composite'),
                ),
                'my_fake_xorX_composite'
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                ),
                array(
                    array('andX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_andX_composite'),
                ),
                'my_fake_andX_composite'
            ),
            array(
                'fieldA=1!&fieldB=2!&fieldC=3',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                ),
                array(
                    array('nandX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_nandX_composite'),
                ),
                'my_fake_nandX_composite'
            ),

            // Precedences
            array(
                'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                    array('eq', 'fieldD', 4, 'my_fake_comparison_D'),
                ),
                array(
                    array('andX', array('my_fake_comparison_C', 'my_fake_comparison_D'), 'my_fake_andX_composite'),
                    array('orX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_andX_composite'), 'my_fake_orX_composite'),
                ),
                'my_fake_orX_composite'
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3!&fieldD=4',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                    array('eq', 'fieldD', 4, 'my_fake_comparison_D'),
                ),
                array(
                    array('andX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_andX_composite'),
                    array('nandX', array('my_fake_andX_composite', 'my_fake_comparison_D'), 'my_fake_orX_composite'),
                ),
                'my_fake_orX_composite'
            ),
            array(
                'fieldA=1|fieldB=2|fieldC=3!|fieldD=4',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                    array('eq', 'fieldD', 4, 'my_fake_comparison_D'),
                ),
                array(
                    array('orX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_orX_composite'),
                    array('norX', array('my_fake_orX_composite', 'my_fake_comparison_D'), 'my_fake_norX_composite'),
                ),
                'my_fake_norX_composite'
            ),
            array(
                'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                    array('eq', 'fieldD', 4, 'my_fake_comparison_D'),
                ),
                array(
                    array('andX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_andX_composite'),
                    array('orX', array('my_fake_andX_composite', 'my_fake_comparison_D'), 'my_fake_orX_composite'),
                ),
                'my_fake_orX_composite'
            ),
            array(
                'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                    array('eq', 'fieldD', 4, 'my_fake_comparison_D'),
                ),
                array(
                    array('andX', array('my_fake_comparison_A', 'my_fake_comparison_B'), 'my_fake_andX_composite_1'),
                    array('andX', array('my_fake_comparison_C', 'my_fake_comparison_D'), 'my_fake_andX_composite_2'),
                    array('orX', array('my_fake_andX_composite_1', 'my_fake_andX_composite_2'), 'my_fake_orX_composite'),
                ),
                'my_fake_orX_composite'
            ),
            array(
                'fieldA=1|fieldB=2|fieldC=3⊕fieldD=4',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                    array('eq', 'fieldD', 4, 'my_fake_comparison_D'),
                ),
                array(
                    array('orX', array('my_fake_comparison_A', 'my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_orX_composite'),
                    array('xorX', array('my_fake_orX_composite', 'my_fake_comparison_D'), 'my_fake_xorX_composite'),
                ),
                'my_fake_xorX_composite'
            ),

            //Parenthesis
            array(
                '((fieldA=1))',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                ),
                array(),
                'my_fake_comparison_A'
            ),
            array(
                '(fieldA=1|fieldB=2)&fieldC=3',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                ),
                array(
                    array('orX', array('my_fake_comparison_A', 'my_fake_comparison_B'), 'my_fake_orX_composite'),
                    array('andX', array('my_fake_orX_composite', 'my_fake_comparison_C'), 'my_fake_andX_composite'),
                ),
                'my_fake_andX_composite'
            ),
            array(
                'fieldA=1|(fieldB=2&fieldC=3)',
                array(
                    array('eq', 'fieldA', 1, 'my_fake_comparison_A'),
                    array('eq', 'fieldB', 2, 'my_fake_comparison_B'),
                    array('eq', 'fieldC', 3, 'my_fake_comparison_C'),
                ),
                array(
                    array('andX', array('my_fake_comparison_B', 'my_fake_comparison_C'), 'my_fake_andX_composite'),
                    array('orX', array('my_fake_comparison_A', 'my_fake_andX_composite'), 'my_fake_orX_composite'),
                ),
                'my_fake_orX_composite'
            ),
        );
    }

    /**
     * @dataProvider parseSuccessDataProvider
     *
     * @param $input
     * @param $comparisonMethods
     * @param $compositeMethods
     */
    public function testParseSuccess($input, $comparisonMethods, $compositeMethods, $expectedResult)
    {
        foreach ($comparisonMethods as $comparisonMethod) {
            $this->expressionBuilderMock
                ->{$comparisonMethod[0]}($comparisonMethod[1], $comparisonMethod[2])
                ->willReturn($comparisonMethod[3])
                ->shouldBeCalled();
        }

        foreach ($compositeMethods as $compositeMethod) {
            $this->expressionBuilderMock
                ->{$compositeMethod[0]}($compositeMethod[1])
                ->willReturn($compositeMethod[2])
                ->shouldBeCalled();
        }

        $this->assertEquals($expectedResult, $this->parser->parse($input));
    }

    public function forbiddenTokenDataProvider()
    {
        return array(
            array(','),
            array('9'),
            array('"string"'),
            array("'string'"),
            array('param'),
            array('4.5'),
            array('='),
            array('≠'),
            array('>'),
            array('≥'),
            array('<'),
            array('≤'),
            array('&'),
            array('!&'),
            array('|'),
            array('!|'),
            array('^|'),
            array('⊕'),
            array('('),
            array(')'),
            array('['),
            array('!['),
            array(']'),
            array('{{'),
            array('!{{'),
            array('}}'),
        );
    }

    /**
     * @dataProvider forbiddenTokenDataProvider
     * @expectedException \Symftony\Xpression\Exception\Parser\InvalidExpressionException
     *
     * @param $input
     */
    public function testForbiddenToken($input)
    {
        $this->parser->parse($input, Lexer::T_NONE);
    }

    /**
     * @expectedException \Symftony\Xpression\Exception\Parser\InvalidExpressionException
     */
    public function testUnexpectedToken()
    {
        $this->expressionBuilderMock->eq('fieldA', 'foo')->willReturn('fake_return');

        $this->parser->parse('fieldA=foo=1');
    }

    /**
     * @expectedException \Symftony\Xpression\Exception\Parser\InvalidExpressionException
     */
    public function testUnsupportedToken()
    {
        $this->expressionBuilderMock->getSupportedTokenType()->willReturn(Lexer::T_NONE)->shouldBeCalled();

        $this->parser->parse('fieldA=1');
    }
}
