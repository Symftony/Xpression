<?php

namespace Tests\Symftony\Xpression;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Expr\Comparison;
use Symftony\Xpression\Expr\CompositeExpression;
use Symftony\Xpression\Expr\ExpressionBuilder;
use Symftony\Xpression\Parser;

class ParserTest extends TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new Parser(new ExpressionBuilder());
    }

    public function parseSuccessDataProvider()
    {
        return [
            [
                'fieldA=1',
                new Comparison('fieldA', '=', 1),
            ],
            [
                'fieldA≥1',
                new Comparison('fieldA', '>=', 1),
            ],
            [
                'fieldA≠1',
                new Comparison('fieldA', '<>', 1),
            ],
            [
                'fieldA>=1',
                new Comparison('fieldA', '>=', 1),
            ],
            [
                'fieldA!=1',
                new Comparison('fieldA', '<>', 1),
            ],
            [
                'fieldA=1|fieldB=2',
                new CompositeExpression('OR', [
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                ]),
            ],
            [
                'fieldA=1&fieldB=2',
                new CompositeExpression('AND', [
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '=', 2),
                ]),
            ],
            [
                'fieldA=1|fieldB=2&fieldC=3',
                new CompositeExpression('OR', [
                    new Comparison('fieldA', '=', 1),
                    new CompositeExpression('AND', [
                        new Comparison('fieldB', '=', 2),
                        new Comparison('fieldC', '=', 3),
                    ]),
                ]),
            ],
            [
                'fieldA=1&fieldB=2|fieldC=3',
                new CompositeExpression('OR', [
                    new CompositeExpression('AND', [
                        new Comparison('fieldA', '=', 1),
                        new Comparison('fieldB', '=', 2),
                    ]),
                    new Comparison('fieldC', '=', 3),
                ]),
            ],
//            [
//                'fieldA=1&fieldB=2|c=3&d=4',
//                new CompositeExpression('OR', [
//                    new CompositeExpression('AND', [
//                        new Comparison('fieldA', '=', 1),
//                        new Comparison('fieldB', '=', 2),
//                    ]),
//                    new CompositeExpression('AND', [
//                        new Comparison('c', '=', 3),
//                        new Comparison('d', '=', 4),
//                    ]),
//                ]),
//            ],
//            [
//                'fieldA[1,2]',
//                new Comparison('fieldA', 'IN', [1, 2]),
//            ],
//            [
//                'fieldA![1,2]',
//                new Comparison('fieldA', 'NIN', [1, 2]),
//            ],
//            [
//                '(a=1|b=2)&c=3',
//                new CompositeExpression('AND', [
//                    new CompositeExpression('OR', [
//                        new Comparison('a', '=', 1),
//                        new Comparison('b', '=', 2),
//                    ]),
//                    new Comparison('c', '=', 3),
//                ]),
//            ],
//            [
//                'a=1|(b=2&c=3)',
//                new CompositeExpression('OR', [
//                    new Comparison('a', '=', 1),
//                    new CompositeExpression('AND', [
//                        new Comparison('b', '=', 2),
//                        new Comparison('c', '=', 3),
//                    ]),
//                ]),
//            ],
        ];
    }

    /**
     * @dataProvider parseSuccessDataProvider
     *
     * @param $input
     * @param $expectedExpression
     */
    public function testParseSuccess($input, $expectedExpression)
    {
        $this->assertEquals($expectedExpression, $this->parser->parse($input));
    }
}
