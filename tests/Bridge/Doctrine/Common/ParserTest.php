<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\Common;

use Doctrine\Common\Collections\Expr\Expression;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
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

    public function setUp(): void
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            $this->markTestSkipped('This test is run when you have "doctrine/collection" installed.');
        }
        $this->expressionBuilderAdapter = new ExpressionBuilderAdapter(new ExpressionBuilder());
        $this->parser = new Parser($this->expressionBuilderAdapter);
    }

    public function parseSuccessDataProvider(): array
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            return [];
        }

        return [
            [
                'fieldA=1',
                new Comparison('fieldA', '=', 1),
            ],
            [
                'fieldA="string"',
                new Comparison('fieldA', '=', 'string'),
            ],
            [
                'fieldA≥1',
                new Comparison('fieldA', '>=', 1),
            ],
            [
                'fieldA>=1',
                new Comparison('fieldA', '>=', 1),
            ],
            [
                'fieldA≤1',
                new Comparison('fieldA', '<=', 1),
            ],
            [
                'fieldA<=1',
                new Comparison('fieldA', '<=', 1),
            ],
            [
                'fieldA≠1',
                new Comparison('fieldA', '<>', 1),
            ],
            [
                'fieldA!=1',
                new Comparison('fieldA', '<>', 1),
            ],
            [
                'fieldA[1,2]',
                new Comparison('fieldA', 'IN', [1, 2]),
            ],
            [
                'fieldA![1,2]',
                new Comparison('fieldA', 'NIN', [1, 2]),
            ],
            [
                'fieldA=1|fieldB=2|fieldC=3',
                new CompositeExpression('OR', [
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                    new Comparison('fieldC', '=', 3),
                ]),
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3',
                new CompositeExpression('AND', [
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                    new Comparison('fieldC', '=', 3),
                ]),
            ],

            // Precedences
            [
                'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
                new CompositeExpression('OR', [
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                    new CompositeExpression('AND', [
                        new Comparison('fieldC', '=', 3),
                        new Comparison('fieldD', '=', 4),
                    ]),
                ]),
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
                new CompositeExpression('OR', [
                    new CompositeExpression('AND', [
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                        new Comparison('fieldC', '=', 3),
                    ]),
                    new Comparison('fieldD', '=', 4),
                ]),
            ],
            [
                'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
                new CompositeExpression('OR', [
                    new CompositeExpression('AND', [
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                    ]),
                    new CompositeExpression('AND', [
                        new Comparison('fieldC', '=', 3),
                        new Comparison('fieldD', '=', 4),
                    ]),
                ]),
            ],

            //Parenthesis
            [
                '((fieldA=1))',
                new Comparison('fieldA', '=', 1),
            ],
            [
                '(fieldA=1|fieldB=2)&fieldC=3',
                new CompositeExpression('AND', [
                    new CompositeExpression('OR', [
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                    ]),
                    new Comparison('fieldC', '=', 3),
                ]),
            ],
            [
                'fieldA=1|(fieldB=2&fieldC=3)',
                new CompositeExpression('OR', [
                    new Comparison('fieldA', '=', 1),
                    new CompositeExpression('AND', [
                        new Comparison('fieldB', '=', 2),
                        new Comparison('fieldC', '=', 3),
                    ]),
                ]),
            ],
        ];
    }

    /**
     * @dataProvider parseSuccessDataProvider
     */
    public function testParser(string $input, Expression $expectedExpression): void
    {
        $this->assertEquals($expectedExpression, $this->parser->parse($input));
    }

    public function unsupportedExpressionTypeDataProvider(): array
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            return [];
        }

        return [
            ['fieldA=1|fieldB=2|fieldC=3⊕fieldD=4'],
            ['fieldA=1!|fieldB=2!|fieldC=3'],
            ['fieldA=1^|fieldB=2'],
            ['fieldA=1⊕fieldB=2'],
            ['fieldA=1!&fieldB=2!&fieldC=3'],
            ['fieldA=1&fieldB=2&fieldC=3!&fieldD=4'],
            ['fieldA=1|fieldB=2|fieldC=3!|fieldD=4'],
            ['fieldA!{{1}}'],
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
