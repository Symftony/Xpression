<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression\Bridge\MongoDB;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\MongoDB\ExprBuilder;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Parser;

/**
 * @covers \Symftony\Xpression\Parser
 * @covers \Symftony\Xpression\Bridge\MongoDB\ExprBuilder
 */
final class ParserTest extends TestCase
{
    private ExprBuilder $exprBuilder;

    private Parser $parser;

    protected function setUp(): void
    {
        $this->exprBuilder = new ExprBuilder();
        $this->parser = new Parser($this->exprBuilder);
    }

    public static function provideParserCases(): iterable
    {
        yield [
            'fieldA=1',
            ['fieldA' => ['$eq' => 1]],
        ];

        yield [
            'fieldA="string"',
            ['fieldA' => ['$eq' => 'string']],
        ];

        yield [
            'fieldA≥1',
            ['fieldA' => ['$gte' => 1]],
        ];

        yield [
            'fieldA>=1',
            ['fieldA' => ['$gte' => 1]],
        ];

        yield [
            'fieldA≤1',
            ['fieldA' => ['$lte' => 1]],
        ];

        yield [
            'fieldA<=1',
            ['fieldA' => ['$lte' => 1]],
        ];

        yield [
            'fieldA≠1',
            ['fieldA' => ['$ne' => 1]],
        ];

        yield [
            'fieldA!=1',
            ['fieldA' => ['$ne' => 1]],
        ];

        yield [
            'fieldA[1,2]',
            ['fieldA' => ['$in' => [1, 2]]],
        ];

        yield [
            'fieldA![1,2]',
            ['fieldA' => ['$nin' => [1, 2]]],
        ];

        yield [
            'fieldA{{1}}',
            ['fieldA' => ['$regex' => 1]],
        ];

        yield [
            'fieldA!{{1}}',
            ['$not' => ['fieldA' => ['$regex' => 1]]],
        ];

        yield [
            'fieldA=1|fieldB=2|fieldC=3',
            [
                '$or' => [
                    ['fieldA' => ['$eq' => 1]],
                    ['fieldB' => ['$eq' => 2]],
                    ['fieldC' => ['$eq' => 3]],
                ],
            ],
        ];

        yield [
            'fieldA=1&fieldB=2&fieldC=3',
            [
                '$and' => [
                    ['fieldA' => ['$eq' => 1]],
                    ['fieldB' => ['$eq' => 2]],
                    ['fieldC' => ['$eq' => 3]],
                ],
            ],
        ];

        // Precedences
        yield [
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
        ];

        yield [
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
        ];

        yield [
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
        ];

        // Parenthesis
        yield [
            '((fieldA=1))',
            ['fieldA' => ['$eq' => 1]],
        ];

        yield [
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
        ];

        yield [
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
        ];
    }

    /**
     * @dataProvider provideParserCases
     */
    public function testParser(string $input, array $expectedExpression): void
    {
        self::assertSame($expectedExpression, $this->parser->parse($input));
    }

    public static function provideParserThrowUnsupportedExpressionTypeExceptionCases(): iterable
    {
        yield ['fieldA=1^|fieldB=2'];

        yield ['fieldA=1⊕fieldB=2'];

        yield ['fieldA=1|fieldB=2|fieldC=3⊕fieldD=4'];
    }

    /**
     * @dataProvider provideParserThrowUnsupportedExpressionTypeExceptionCases
     */
    public function testParserThrowUnsupportedExpressionTypeException(string $input): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->expectExceptionMessage('Invalid expression.');
        $this->parser->parse($input);
    }
}
