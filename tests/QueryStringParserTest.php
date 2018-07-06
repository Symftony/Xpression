<?php

namespace Tests\Symftony\Xpression;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\QueryStringParser;

class QueryStringParserTest extends TestCase
{
    public function parseDataProvider()
    {
        return array(
            // Default querystring
            array(
                'param-A',
                'param-A',
                array(
                    'param-A' => '',
                )
            ),
            array(
                'param-A=',
                'param-A=',
                array(
                    'param-A' => '',
                )
            ),
            array(
                'param-A=valueA',
                'param-A=valueA',
                array(
                    'param-A' => 'valueA',
                )
            ),
            array(
                'param-A[]=valueA',
                'param-A[]=valueA',
                array(
                    'param-A' => array('valueA'),
                )
            ),
            array(
                'param-A[subA]=valueA',
                'param-A[subA]=valueA',
                array(
                    'param-A' => array('subA' => 'valueA'),
                )
            ),
            array(
                'param-A&param-B',
                'param-A&param-B',
                array(
                    'param-A' => '',
                    'param-B' => '',
                )
            ),
            array(
                'param-A=&param-B',
                'param-A=&param-B',
                array(
                    'param-A' => '',
                    'param-B' => '',
                )
            ),
            array(
                'param-A=valueA&param-B',
                'param-A=valueA&param-B',
                array(
                    'param-A' => 'valueA',
                    'param-B' => '',
                )
            ),
            array(
                'param-A[]=valueA&param-B',
                'param-A[]=valueA&param-B',
                array(
                    'param-A' => array('valueA'),
                    'param-B' => '',
                )
            ),
            array(
                'param-A[subA]=valueA&param-B',
                'param-A[subA]=valueA&param-B',
                array(
                    'param-A' => array('subA' => 'valueA'),
                    'param-B' => '',
                )
            ),

            // With Xpression
            array(
                'query{{valueA}}',
                'query{{valueA}}',
                array(
                    'query{{valueA}}' => '',
                )
            ),
            array(
                'query={price{{test}}&price=6}',
                'query=price%7B%7Btest%7D%7D%26price%3D6',
                array(
                    'query' => 'price{{test}}&price=6',
                )
            ),
            array(
                'query={name{{test 2}}}',
                'query=name%7B%7Btest+2%7D%7D',
                array(
                    'query' => 'name{{test 2}}',
                )
            ),
            array(
                'query={valueA}',
                'query=valueA',
                array(
                    'query' => 'valueA',
                )
            ),
            array(
                'query[]={valueA}',
                'query[]=valueA',
                array(
                    'query' => array('valueA'),
                )
            ),
            array(
                'query[subA]={valueA}',
                'query[subA]=valueA',
                array(
                    'query' => array('subA' => 'valueA'),
                )
            ),
            array(
                'query-A={valueA}&query-B={valueB}',
                'query-A=valueA&query-B=valueB',
                array(
                    'query-A' => 'valueA',
                    'query-B' => 'valueB',
                )
            ),
            array(
                'query-A[]={valueA1}&query-A[]={valueA2}&query-B={valueB}',
                'query-A[]=valueA1&query-A[]=valueA2&query-B=valueB',
                array(
                    'query-A' => array('valueA1', 'valueA2'),
                    'query-B' => 'valueB',
                )
            ),
            array(
                'query-A[subA]={valueA}&query-B={valueB}',
                'query-A[subA]=valueA&query-B=valueB',
                array(
                    'query-A' => array('subA' => 'valueA'),
                    'query-B' => 'valueB',
                )
            ),

            // Fail
            array(
                'query-A=valueA}',
                'query-A=valueA}',
                array(
                    'query-A' => 'valueA}',
                )
            ),
            array(
                'query-A={valueA',
                'query-A={valueA',
                array(
                    'query-A' => '{valueA',
                )
            ),
            array(
                'query-A={}valueA',
                'query-A={}valueA',
                array(
                    'query-A' => '{}valueA',
                )
            ),
            array(
                'query-A={{valueA}}',
                'query-A={{valueA}}',
                array(
                    'query-A' => '{{valueA}}',
                )
            ),
        );
    }

    /**
     * @dataProvider parseDataProvider
     *
     * @param $queryString
     * @param $expectedQueryString
     * @param $expectedGET
     */
    public function testParse($queryString, $expectedQueryString, $expectedGET)
    {
        $_SERVER['QUERY_STRING'] = $queryString;
        QueryStringParser::correctServerQueryString();

        $this->assertEquals($expectedQueryString, $_SERVER['QUERY_STRING']);
        $this->assertEquals($expectedGET, $_GET);
    }
}
