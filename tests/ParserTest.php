<?php

declare(strict_types=1);

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

/**
 * @internal
 *
 * @coversNothing
 */
final class ParserTest extends TestCase
{
    private ExpressionBuilderInterface|ObjectProphecy $expressionBuilderMock;

    private Parser $parser;

    protected function setUp(): void
    {
        $this->expressionBuilderMock = (new Prophet())->prophesize(ExpressionBuilderInterface::class);
        $this->expressionBuilderMock->getSupportedTokenType()->willReturn(Lexer::T_ALL);

        $this->parser = new Parser($this->expressionBuilderMock->reveal());
    }

    public static function provideParseSuccessCases(): iterable
    {
        $prophet = new Prophet();

        $expr1 = $prophet->prophesize(Expression::class)->reveal();
        $expr2 = $prophet->prophesize(Expression::class)->reveal();
        $expr3 = $prophet->prophesize(Expression::class)->reveal();
        $expr4 = $prophet->prophesize(Expression::class)->reveal();
        $composite1 = $prophet->prophesize(CompositeExpression::class)->reveal();
        $composite2 = $prophet->prophesize(CompositeExpression::class)->reveal();
        $composite3 = $prophet->prophesize(CompositeExpression::class)->reveal();

        yield [
            'fieldA=1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        //            [
        //                'fieldA="string"',
        //                [['eq', 'fieldA', 'my_fake_string', 'my_fake_comparison_A']],
        //                [['valueAsString', 'string', 'my_fake_string']],
        //                'my_fake_comparison_A',
        //            ],
        yield [
            'fieldA>1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->gt('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA≥1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->gte('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA>=1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->gte('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA<1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->lt('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA≤1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->lte('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA<=1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->lte('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA≠1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->neq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA!=1',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->neq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA[1,2]',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->in('fieldA', [1, 2])->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA![1,2]',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->notIn('fieldA', [1, 2])->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA{{1}}',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->contains('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            'fieldA!{{1}}',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->notContains('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        // Composite
        yield [
            'fieldA=1|fieldB=2|fieldC=3',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->orX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
            },
            $composite1,
        ];

        yield [
            'fieldA=1!|fieldB=2!|fieldC=3',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->norX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
            },
            $composite1,
        ];

        yield [
            'fieldA=1^|fieldB=2^|fieldC=3',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->xorX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
            },
            $composite1,
        ];

        yield [
            'fieldA=1⊕fieldB=2⊕fieldC=3',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->xorX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
            },
            $composite1,
        ];

        yield [
            'fieldA=1&fieldB=2&fieldC=3',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->andX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
            },
            $composite1,
        ];

        yield [
            'fieldA{{value}}&fieldB=2',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $composite1): void {
                $mock->contains('fieldA', 'value')->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->andX([$expr1, $expr2])->willReturn($composite1)->shouldBeCalled();
            },
            $composite1,
        ];

        yield [
            'fieldA=1!&fieldB=2!&fieldC=3',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->nandX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
            },
            $composite1,
        ];

        // Precedences
        yield [
            'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                // And was before OR
                $mock->andX([$expr3, $expr4])->willReturn($composite1)->shouldBeCalled();
                $mock->orX([$expr1, $expr2, $composite1])->willReturn($composite2)->shouldBeCalled();
            },
            $composite2,
        ];

        yield [
            'fieldA=1&fieldB=2&fieldC=3!&fieldD=4',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                $mock->andX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                $mock->nandX([$composite1, $expr4])->willReturn($composite2)->shouldBeCalled();
            },
            $composite2,
        ];

        yield [
            'fieldA=1|fieldB=2|fieldC=3!|fieldD=4',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                $mock->orX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                $mock->norX([$composite1, $expr4])->willReturn($composite2)->shouldBeCalled();
            },
            $composite2,
        ];

        yield [
            'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                $mock->andX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                $mock->orX([$composite1, $expr4])->willReturn($composite2)->shouldBeCalled();
            },
            $composite2,
        ];

        yield [
            'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2, $composite3): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                $mock->andX([$expr1, $expr2])->willReturn($composite1)->shouldBeCalled();
                $mock->andX([$expr3, $expr4])->willReturn($composite2)->shouldBeCalled();
                $mock->orX([$composite1, $composite2])->willReturn($composite3)->shouldBeCalled();
            },
            $composite3,
        ];

        yield [
            'fieldA=1|fieldB=2|fieldC=3⊕fieldD=4',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $expr4, $composite1, $composite2): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->eq('fieldD', 4)->willReturn($expr4)->shouldBeCalled();
                $mock->orX([$expr1, $expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                $mock->xorX([$composite1, $expr4])->willReturn($composite2)->shouldBeCalled();
            },
            $composite2,
        ];

        // Parenthesis
        yield [
            '((fieldA=1))',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
            },
            $expr1,
        ];

        yield [
            '(fieldA=1|fieldB=2)&fieldC=3',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1, $composite2): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->orX([$expr1, $expr2])->willReturn($composite1)->shouldBeCalled();
                $mock->andX([$composite1, $expr3])->willReturn($composite2)->shouldBeCalled();
            },
            $composite2,
        ];

        yield [
            'fieldA=1|(fieldB=2&fieldC=3)',
            static function (ExpressionBuilderInterface|ObjectProphecy $mock) use ($expr1, $expr2, $expr3, $composite1, $composite2): void {
                $mock->eq('fieldA', 1)->willReturn($expr1)->shouldBeCalled();
                $mock->eq('fieldB', 2)->willReturn($expr2)->shouldBeCalled();
                $mock->eq('fieldC', 3)->willReturn($expr3)->shouldBeCalled();
                $mock->andX([$expr2, $expr3])->willReturn($composite1)->shouldBeCalled();
                $mock->orX([$expr1, $composite1])->willReturn($composite2)->shouldBeCalled();
            },
            $composite2,
        ];
    }

    /**
     * @dataProvider provideParseSuccessCases
     *
     * @param mixed $expectedResult
     */
    public function testParseSuccess(string $input, callable $configureExpressionBuilderMock, $expectedResult): void
    {
        $configureExpressionBuilderMock($this->expressionBuilderMock);

        self::assertSame($expectedResult, $this->parser->parse($input));
    }

    public static function provideForbiddenTokenCases(): iterable
    {
        yield [','];

        yield ['9'];

        yield ['"string"'];

        yield ["'string'"];

        yield ['param'];

        yield ['4.5'];

        yield ['='];

        yield ['≠'];

        yield ['>'];

        yield ['≥'];

        yield ['<'];

        yield ['≤'];

        yield ['&'];

        yield ['!&'];

        yield ['|'];

        yield ['!|'];

        yield ['^|'];

        yield ['⊕'];

        yield ['('];

        yield [')'];

        yield ['['];

        yield ['!['];

        yield [']'];

        yield ['{{'];

        yield ['!{{'];

        yield ['}}'];
    }

    /**
     * @dataProvider provideForbiddenTokenCases
     */
    public function testForbiddenToken(string $input): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->expectExceptionMessage('Invalid expression.');
        $this->parser->parse($input, Lexer::T_NONE);
    }

    public function testUnexpectedToken(): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->expectExceptionMessage('Invalid expression.');
        $this->parser->parse('fieldA==foo=1');
    }

    public function testUnsupportedToken(): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->expectExceptionMessage('Invalid expression.');
        $this->expressionBuilderMock->getSupportedTokenType()->willReturn(Lexer::T_NONE)->shouldBeCalled();

        $this->parser->parse('fieldA=1');
    }
}
