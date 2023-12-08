<?php

namespace Tests\Symftony\Xpression;

use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\Expr\Expression;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Lexer;
use Symftony\Xpression\Parser;

class ParserTest extends TestCase
{
    private ExpressionBuilderInterface|ObjectProphecy $expressionBuilderMock;

    private Parser $parser;
    private Prophet $prophet;

    public function setUp(): void
    {
        $this->prophet = new Prophet();
        $this->expressionBuilderMock = $this->prophet->prophesize(ExpressionBuilderInterface::class);
        $this->expressionBuilderMock->getSupportedTokenType()->willReturn(Lexer::T_ALL);

        $this->parser = new Parser($this->expressionBuilderMock->reveal());
    }

    public function parseSuccessDataProvider(): array
    {
        $expr1 = $this->createMock(Expression::class);
        $expr2 = $this->createMock(Expression::class);
        $expr3 = $this->createMock(Expression::class);
        $expr4 = $this->createMock(Expression::class);
        $composite1 = $this->createMock(CompositeExpression::class);
        $composite2 = $this->createMock(CompositeExpression::class);
        $composite3 = $this->createMock(CompositeExpression::class);
        return [
            [
                'fieldA=1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
//            [
//                'fieldA="string"',
//                [['eq', 'fieldA', 'my_fake_string', 'my_fake_comparison_A']],
//                [['valueAsString', 'string', 'my_fake_string']],
//                'my_fake_comparison_A',
//            ],
            [
                'fieldA>1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->gt('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA≥1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->gte('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA>=1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->gte('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA<1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->lt('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA≤1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->lte('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA<=1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->lte('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA≠1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->neq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA!=1',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->neq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA[1,2]',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->in('fieldA', [1, 2])->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA![1,2]',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->notIn('fieldA', [1, 2])->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA{{1}}',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->contains('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                'fieldA!{{1}}',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1) {
                    $mock->notContains('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],

            // Composite
            [
                'fieldA=1|fieldB=2|fieldC=3',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->orX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                },
                $composite1,
            ],
            [
                'fieldA=1!|fieldB=2!|fieldC=3',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->norX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                },
                $composite1,
            ],
            [
                'fieldA=1^|fieldB=2^|fieldC=3',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->xorX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                },
                $composite1,
            ],
            [
                'fieldA=1⊕fieldB=2⊕fieldC=3',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->xorX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                },
                $composite1,
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->andX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                },
                $composite1,
            ],
            [
                'fieldA{{value}}&fieldB=2',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $composite1) {
                    $mock->contains('fieldA', 'value')->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->andX([$expr1, $expr2])->willReturn($composite1)->shouldBeCalled();
                },
                $composite1,
            ],
            [
                'fieldA=1!&fieldB=2!&fieldC=3',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->nandX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                },
                $composite1,
            ],

            // Precedences
            [
                'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                    // And was before OR
                    $mock->andX([$expr3, $expr4])->willReturn($composite1)->shouldBeCalled();
                    $mock->orX([$expr1, $expr2, $composite1])->willReturn($composite2)->shouldBeCalled();
                },
                $composite2,
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3!&fieldD=4',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                    $mock->andX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                    $mock->nandX([$composite1, $expr4])->willReturn($composite2)->shouldBeCalled();
                },
                $composite2,
            ],
            [
                'fieldA=1|fieldB=2|fieldC=3!|fieldD=4',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                    $mock->orX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                    $mock->norX([$composite1, $expr4])->willReturn($composite2)->shouldBeCalled();
                },
                $composite2,
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                    $mock->andX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                    $mock->orX([$composite1, $expr4])->willReturn($composite2)->shouldBeCalled();
                },
                $composite2,
            ],
            [
                'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2, $composite3) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                    $mock->andX([$expr1, $expr2])->willReturn($composite1)->shouldBeCalled();
                    $mock->andX([$expr3, $expr4])->willReturn($composite2)->shouldBeCalled();
                    $mock->orX([$composite1, $composite2])->willReturn($composite3)->shouldBeCalled();
                },
                $composite3,
            ],
            [
                'fieldA=1|fieldB=2|fieldC=3⊕fieldD=4',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                    $mock->orX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                    $mock->xorX([$composite1, $expr4])->willReturn($composite2)->shouldBeCalled();
                },
                $composite2,
            ],

            //Parenthesis
            [
                '((fieldA=1))',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                },
                $expr1,
            ],
            [
                '(fieldA=1|fieldB=2)&fieldC=3',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1, $composite2) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->orX([$expr1, $expr2])->willReturn($composite1)->shouldBeCalled();
                    $mock->andX([$composite1, $expr3])->willReturn($composite2)->shouldBeCalled();
                },
                $composite2,
            ],
            [
                'fieldA=1|(fieldB=2&fieldC=3)',
                function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1, $composite2) {
                    $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                    $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                    $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                    $mock->andX([$expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                    $mock->orX([$expr1, $composite1])->willReturn($composite2)->shouldBeCalled();
                },
                $composite2,
            ],
        ];
    }

    /**
     * @dataProvider parseSuccessDataProvider
     */
    public function testParseSuccess(string $input, callable $configureExpressionBuilderMock, $expectedResult): void
    {
        $configureExpressionBuilderMock($this->expressionBuilderMock);

        $this->assertEquals($expectedResult, $this->parser->parse($input));
    }

    public function forbiddenTokenDataProvider(): array
    {
        return [
            [','],
            ['9'],
            ['"string"'],
            ["'string'"],
            ['param'],
            ['4.5'],
            ['='],
            ['≠'],
            ['>'],
            ['≥'],
            ['<'],
            ['≤'],
            ['&'],
            ['!&'],
            ['|'],
            ['!|'],
            ['^|'],
            ['⊕'],
            ['('],
            [')'],
            ['['],
            ['!['],
            [']'],
            ['{{'],
            ['!{{'],
            ['}}'],
        ];
    }

    /**
     * @dataProvider forbiddenTokenDataProvider
     */
    public function testForbiddenToken(string $input): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->parser->parse($input, Lexer::T_NONE);
    }

    public function testUnexpectedToken(): void
    {
        $this->expectException(InvalidExpressionException::class);

        $this->parser->parse('fieldA==foo=1');
    }

    public function testUnsupportedToken(): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->expressionBuilderMock->getSupportedTokenType()->willReturn(Lexer::T_NONE)->shouldBeCalled();

        $this->parser->parse('fieldA=1');
    }
}
