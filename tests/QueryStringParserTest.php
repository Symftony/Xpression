<?php

namespace Tests\Symftony\Xpression;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\QueryStringParser;

class QueryStringParserTest extends TestCase
{
    public function parseDataProvider(): array
    {
        return [
            // Default querystring
            [
                'param-A',
                'param-A',
                [
                    'param-A' => '',
                ],
            ],
            [
                'param-A=',
                'param-A=',
                [
                    'param-A' => '',
                ],
            ],
            [
                'param-A=valueA',
                'param-A=valueA',
                [
                    'param-A' => 'valueA',
                ],
            ],
            [
                'param-A[]=valueA',
                'param-A[]=valueA',
                [
                    'param-A' => ['valueA'],
                ],
            ],
            [
                'param-A[subA]=valueA',
                'param-A[subA]=valueA',
                [
                    'param-A' => ['subA' => 'valueA'],
                ],
            ],
            [
                'param-A&param-B',
                'param-A&param-B',
                [
                    'param-A' => '',
                    'param-B' => '',
                ],
            ],
            [
                'param-A=&param-B',
                'param-A=&param-B',
                [
                    'param-A' => '',
                    'param-B' => '',
                ],
            ],
            [
                'param-A=valueA&param-B',
                'param-A=valueA&param-B',
                [
                    'param-A' => 'valueA',
                    'param-B' => '',
                ],
            ],
            [
                'param-A[]=valueA&param-B',
                'param-A[]=valueA&param-B',
                [
                    'param-A' => ['valueA'],
                    'param-B' => '',
                ],
            ],
            [
                'param-A[subA]=valueA&param-B',
                'param-A[subA]=valueA&param-B',
                [
                    'param-A' => ['subA' => 'valueA'],
                    'param-B' => '',
                ],
            ],

            // With Xpression
            [
                'query{{valueA}}',
                'query{{valueA}}',
                [
                    'query{{valueA}}' => '',
                ],
            ],
            [
                'query={price{{test}}&price=6}',
                'query=price%7B%7Btest%7D%7D%26price%3D6',
                [
                    'query' => 'price{{test}}&price=6',
                ],
            ],
            [
                'query={name{{test 2}}}',
                'query=name%7B%7Btest+2%7D%7D',
                [
                    'query' => 'name{{test 2}}',
                ],
            ],
            [
                'query={valueA}',
                'query=valueA',
                [
                    'query' => 'valueA',
                ],
            ],
            [
                'query[]={valueA}',
                'query[]=valueA',
                [
                    'query' => ['valueA'],
                ],
            ],
            [
                'query[subA]={valueA}',
                'query[subA]=valueA',
                [
                    'query' => ['subA' => 'valueA'],
                ],
            ],
            [
                'query-A={valueA}&query-B={valueB}',
                'query-A=valueA&query-B=valueB',
                [
                    'query-A' => 'valueA',
                    'query-B' => 'valueB',
                ],
            ],
            [
                'query-A[]={valueA1}&query-A[]={valueA2}&query-B={valueB}',
                'query-A[]=valueA1&query-A[]=valueA2&query-B=valueB',
                [
                    'query-A' => ['valueA1', 'valueA2'],
                    'query-B' => 'valueB',
                ],
            ],
            [
                'query-A[subA]={valueA}&query-B={valueB}',
                'query-A[subA]=valueA&query-B=valueB',
                [
                    'query-A' => ['subA' => 'valueA'],
                    'query-B' => 'valueB',
                ],
            ],

            // Fail
            [
                'query-A=valueA}',
                'query-A=valueA}',
                [
                    'query-A' => 'valueA}',
                ],
            ],
            [
                'query-A={valueA',
                'query-A={valueA',
                [
                    'query-A' => '{valueA',
                ],
            ],
            [
                'query-A={}valueA',
                'query-A={}valueA',
                [
                    'query-A' => '{}valueA',
                ],
            ],
            [
                'query-A={{valueA}}',
                'query-A={{valueA}}',
                [
                    'query-A' => '{{valueA}}',
                ],
            ],
        ];
    }

    /**
     * @dataProvider parseDataProvider
     */
    public function testParse(string $queryString, string $expectedQueryString, array $expectedGET)
    {
        $_SERVER['QUERY_STRING'] = $queryString;
        QueryStringParser::correctServerQueryString();

        $this->assertEquals($expectedQueryString, $_SERVER['QUERY_STRING']);
        $this->assertEquals($expectedGET, $_GET);
    }
}
