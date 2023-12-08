<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\ORM;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Parser;

class ParserTest extends TestCase
{
    private ExprAdapter $exprAdapter;

    private Parser $parser;

    public function setUp(): void
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            $this->markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }
        $this->exprAdapter = new ExprAdapter(new Expr());
        $this->parser = new Parser($this->exprAdapter);
    }

    public function parseSuccessDataProvider(): array
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return [];
        }

        return [
            [
                'fieldA=1',
                new Expr\Comparison('fieldA', '=', 1),
            ],
            [
                'fieldA="string"',
                new Expr\Comparison('fieldA', '=', (new Expr())->literal('string')),
            ],
            [
                'fieldA≥1',
                new Expr\Comparison('fieldA', '>=', 1),
            ],
            [
                'fieldA>=1',
                new Expr\Comparison('fieldA', '>=', 1),
            ],
            [
                'fieldA≤1',
                new Expr\Comparison('fieldA', '<=', 1),
            ],
            [
                'fieldA<=1',
                new Expr\Comparison('fieldA', '<=', 1),
            ],
            [
                'fieldA≠1',
                new Expr\Comparison('fieldA', '<>', 1),
            ],
            [
                'fieldA!=1',
                new Expr\Comparison('fieldA', '<>', 1),
            ],
            [
                'fieldA[1,2]',
                new Expr\Func('fieldA IN', [1, 2]),
            ],
            [
                'fieldA![1,2]',
                new Expr\Func('fieldA NOT IN', [1, 2]),
            ],
            [
                'fieldA{{1}}',
                new Expr\Comparison('fieldA', 'LIKE', 1),
            ],
            [
                'fieldA!{{1}}',
                new Expr\Comparison('fieldA', 'NOT LIKE', 1),
            ],
            [
                'fieldA=1|fieldB=2|fieldC=3',
                new Expr\Orx([
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                    new Expr\Comparison('fieldC', '=', 3),
                ]),
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3',
                new Expr\Andx([
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                    new Expr\Comparison('fieldC', '=', 3),
                ]),
            ],

            // Precedences
            [
                'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
                new Expr\Orx([
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                    new Expr\Andx([
                        new Expr\Comparison('fieldC', '=', 3),
                        new Expr\Comparison('fieldD', '=', 4),
                    ]),
                ]),
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
                new Expr\Orx([
                    new Expr\Andx([
                        new Expr\Comparison('fieldA', '=', 1),
                        new Expr\Comparison('fieldB', '=', 2),
                        new Expr\Comparison('fieldC', '=', 3),
                    ]),
                    new Expr\Comparison('fieldD', '=', 4),
                ]),
            ],
            [
                'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
                new Expr\Orx([
                    new Expr\Andx([
                        new Expr\Comparison('fieldA', '=', 1),
                        new Expr\Comparison('fieldB', '=', 2),
                    ]),
                    new Expr\Andx([
                        new Expr\Comparison('fieldC', '=', 3),
                        new Expr\Comparison('fieldD', '=', 4),
                    ]),
                ]),
            ],

            //Parenthesis
            [
                '((fieldA=1))',
                new Expr\Comparison('fieldA', '=', 1),
            ],
            [
                '(fieldA=1|fieldB=2)&fieldC=3',
                new Expr\Andx([
                    new Expr\Orx([
                        new Expr\Comparison('fieldA', '=', 1),
                        new Expr\Comparison('fieldB', '=', 2),
                    ]),
                    new Expr\Comparison('fieldC', '=', 3),
                ]),
            ],
            [
                'fieldA=1|(fieldB=2&fieldC=3)',
                new Expr\Orx([
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Andx([
                        new Expr\Comparison('fieldB', '=', 2),
                        new Expr\Comparison('fieldC', '=', 3),
                    ]),
                ]),
            ],
        ];
    }

    /**
     * @dataProvider parseSuccessDataProvider
     */
    public function testParser(string $input, $expectedExpression): void
    {
        $this->assertEquals($expectedExpression, $this->parser->parse($input));
    }

    public function unsupportedExpressionTypeDataProvider(): array
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return [];
        }

        return [
            ['fieldA=1!|fieldB=2!|fieldC=3'],
            ['fieldA=1^|fieldB=2'],
            ['fieldA=1⊕fieldB=2'],
            ['fieldA=1!&fieldB=2!&fieldC=3'],
            ['fieldA=1&fieldB=2&fieldC=3!&fieldD=4'],
            ['fieldA=1|fieldB=2|fieldC=3!|fieldD=4'],
            ['fieldA=1|fieldB=2|fieldC=3⊕fieldD=4'],
        ];
    }

    /**
     * @dataProvider unsupportedExpressionTypeDataProvider
     */
    public function testParserThrowUnsupportedExpressionTypeException(string $input): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->parser->parse($input);
    }
}
