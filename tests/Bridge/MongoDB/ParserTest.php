<?php

namespace Tests\Symftony\Xpression\Bridge\MongoDB;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\MongoDB\ExprBuilder;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Parser;

class ParserTest extends TestCase
{
    private ExprBuilder $exprBuilder;

    private Parser $parser;

    public function setUp(): void
    {
        $this->exprBuilder = new ExprBuilder();
        $this->parser = new Parser($this->exprBuilder);
    }

    public function parseSuccessDataProvider(): array
    {
        return [
            [
                'fieldA=1',
                [
                    'fieldA' => ['$eq' => 1],
                ],
            ],
            [
                'fieldA="string"',
                [
                    'fieldA' => ['$eq' => 'string'],
                ],
            ],
            [
                'fieldA≥1',
                [
                    'fieldA' => ['$gte' => 1],
                ],
            ],
            [
                'fieldA>=1',
                [
                    'fieldA' => ['$gte' => 1],
                ],
            ],
            [
                'fieldA≤1',
                [
                    'fieldA' => ['$lte' => 1],
                ],
            ],
            [
                'fieldA<=1',
                [
                    'fieldA' => ['$lte' => 1],
                ],
            ],
            [
                'fieldA≠1',
                [
                    'fieldA' => ['$ne' => 1],
                ],
            ],
            [
                'fieldA!=1',
                [
                    'fieldA' => ['$ne' => 1],
                ],
            ],
            [
                'fieldA[1,2]',
                [
                    'fieldA' => ['$in' => [1, 2]],
                ],
            ],
            [
                'fieldA![1,2]',
                [
                    'fieldA' => ['$nin' => [1, 2]],
                ],
            ],
            [
                'fieldA{{1}}',
                [
                    'fieldA' => ['$regex' => 1],
                ],
            ],
            [
                'fieldA!{{1}}',
                [
                    '$not' => ['fieldA' => ['$regex' => 1]],
                ],
            ],
            [
                'fieldA=1|fieldB=2|fieldC=3',
                [
                    '$or' => [
                        ['fieldA' => ['$eq' => 1]],
                        ['fieldB' => ['$eq' => 2]],
                        ['fieldC' => ['$eq' => 3]],
                    ],
                ],
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3',
                [
                    '$and' => [
                        ['fieldA' => ['$eq' => 1]],
                        ['fieldB' => ['$eq' => 2]],
                        ['fieldC' => ['$eq' => 3]],
                    ],
                ],
            ],

            // Precedences
            [
                'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
                [
                    '$or' => [
                        ['fieldA' => ['$eq' => 1]],
                        ['fieldB' => ['$eq' => 2]],
                        [
                            '$and' => [
                                ['fieldC' => ['$eq' => 3]],
                                ['fieldD' => ['$eq' => 4]],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
                [
                    '$or' => [
                        [
                            '$and' => [
                                ['fieldA' => ['$eq' => 1]],
                                ['fieldB' => ['$eq' => 2]],
                                ['fieldC' => ['$eq' => 3]],
                            ],
                        ],
                        ['fieldD' => ['$eq' => 4]],
                    ],
                ],
            ],
            [
                'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
                [
                    '$or' => [
                        [
                            '$and' => [
                                ['fieldA' => ['$eq' => 1]],
                                ['fieldB' => ['$eq' => 2]],
                            ],
                        ],
                        [
                            '$and' => [
                                ['fieldC' => ['$eq' => 3]],
                                ['fieldD' => ['$eq' => 4]],
                            ],
                        ],
                    ],
                ],
            ],

            //Parenthesis
            [
                '((fieldA=1))',
                ['fieldA' => ['$eq' => 1]],
            ],
            [
                '(fieldA=1|fieldB=2)&fieldC=3',
                [
                    '$and' => [
                        [
                            '$or' => [
                                ['fieldA' => ['$eq' => 1]],
                                ['fieldB' => ['$eq' => 2]],
                            ],
                        ],
                        ['fieldC' => ['$eq' => 3]],
                    ],
                ],
            ],
            [
                'fieldA=1|(fieldB=2&fieldC=3)',
                [
                    '$or' => [
                        ['fieldA' => ['$eq' => 1]],
                        [
                            '$and' => [
                                ['fieldB' => ['$eq' => 2]],
                                ['fieldC' => ['$eq' => 3]],
                            ],
                        ],
                    ],
                ],
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
        return [
            ['fieldA=1^|fieldB=2'],
            ['fieldA=1⊕fieldB=2'],
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
