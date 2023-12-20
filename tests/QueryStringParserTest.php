<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\QueryStringParser;

/**
 * @covers \Symftony\Xpression\QueryStringParser
 */
final class QueryStringParserTest extends TestCase
{
    public static function provideParseCases(): iterable
    {
        // Default querystring
        yield [
            'param-A',
            'param-A',
            [
                'param-A' => '',
            ],
        ];

        yield [
            'param-A=',
            'param-A=',
            [
                'param-A' => '',
            ],
        ];

        yield [
            'param-A=valueA',
            'param-A=valueA',
            [
                'param-A' => 'valueA',
            ],
        ];

        yield [
            'param-A[]=valueA',
            'param-A[]=valueA',
            [
                'param-A' => ['valueA'],
            ],
        ];

        yield [
            'param-A[subA]=valueA',
            'param-A[subA]=valueA',
            [
                'param-A' => ['subA' => 'valueA'],
            ],
        ];

        yield [
            'param-A&param-B',
            'param-A&param-B',
            [
                'param-A' => '',
                'param-B' => '',
            ],
        ];

        yield [
            'param-A=&param-B',
            'param-A=&param-B',
            [
                'param-A' => '',
                'param-B' => '',
            ],
        ];

        yield [
            'param-A=valueA&param-B',
            'param-A=valueA&param-B',
            [
                'param-A' => 'valueA',
                'param-B' => '',
            ],
        ];

        yield [
            'param-A[]=valueA&param-B',
            'param-A[]=valueA&param-B',
            [
                'param-A' => ['valueA'],
                'param-B' => '',
            ],
        ];

        yield [
            'param-A[subA]=valueA&param-B',
            'param-A[subA]=valueA&param-B',
            [
                'param-A' => ['subA' => 'valueA'],
                'param-B' => '',
            ],
        ];

        // With Xpression
        yield [
            'query{{valueA}}',
            'query{{valueA}}',
            [
                'query{{valueA}}' => '',
            ],
        ];

        yield [
            'query={price{{test}}&price=6}',
            'query=price%7B%7Btest%7D%7D%26price%3D6',
            [
                'query' => 'price{{test}}&price=6',
            ],
        ];

        yield [
            'query={name{{test 2}}}',
            'query=name%7B%7Btest+2%7D%7D',
            [
                'query' => 'name{{test 2}}',
            ],
        ];

        yield [
            'query={valueA}',
            'query=valueA',
            [
                'query' => 'valueA',
            ],
        ];

        yield [
            'query[]={valueA}',
            'query[]=valueA',
            [
                'query' => ['valueA'],
            ],
        ];

        yield [
            'query[subA]={valueA}',
            'query[subA]=valueA',
            [
                'query' => ['subA' => 'valueA'],
            ],
        ];

        yield [
            'query-A={valueA}&query-B={valueB}',
            'query-A=valueA&query-B=valueB',
            [
                'query-A' => 'valueA',
                'query-B' => 'valueB',
            ],
        ];

        yield [
            'query-A[]={valueA1}&query-A[]={valueA2}&query-B={valueB}',
            'query-A[]=valueA1&query-A[]=valueA2&query-B=valueB',
            [
                'query-A' => ['valueA1', 'valueA2'],
                'query-B' => 'valueB',
            ],
        ];

        yield [
            'query-A[subA]={valueA}&query-B={valueB}',
            'query-A[subA]=valueA&query-B=valueB',
            [
                'query-A' => ['subA' => 'valueA'],
                'query-B' => 'valueB',
            ],
        ];

        // Fail
        yield [
            'query-A=valueA}',
            'query-A=valueA}',
            [
                'query-A' => 'valueA}',
            ],
        ];

        yield [
            'query-A={valueA',
            'query-A={valueA',
            [
                'query-A' => '{valueA',
            ],
        ];

        yield [
            'query-A={}valueA',
            'query-A={}valueA',
            [
                'query-A' => '{}valueA',
            ],
        ];

        yield [
            'query-A={{valueA}}',
            'query-A={{valueA}}',
            [
                'query-A' => '{{valueA}}',
            ],
        ];
    }

    /**
     * @dataProvider provideParseCases
     */
    public function testParse(string $queryString, string $expectedQueryString, array $expectedGET): void
    {
        $_SERVER['QUERY_STRING'] = $queryString;
        QueryStringParser::correctServerQueryString();

        self::assertSame($expectedQueryString, $_SERVER['QUERY_STRING']);
        self::assertSame($expectedGET, $_GET);
    }
}
