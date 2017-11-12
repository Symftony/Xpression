<?php

namespace Tests\Symftony\Xpression;

use Symftony\Xpression\QueryStringParser;

class QueryStringParserTest extends \PHPUnit_Framework_TestCase
{
    public function parseDataProvider()
    {
        return array(
            // Default querystring
            array(
                'param-A',
                array(
                    'param-A' => '',
                )
            ),
            array(
                'param-A=',
                array(
                    'param-A' => '',
                )
            ),
            array(
                'param-A=valueA',
                array(
                    'param-A' => 'valueA',
                )
            ),
            array(
                'param-A[]=valueA',
                array(
                    'param-A' => array('valueA'),
                )
            ),
            array(
                'param-A[subA]=valueA',
                array(
                    'param-A' => array('subA' => 'valueA'),
                )
            ),
            array(
                'param-A&param-B',
                array(
                    'param-A' => '',
                    'param-B' => '',
                )
            ),
            array(
                'param-A=&param-B',
                array(
                    'param-A' => '',
                    'param-B' => '',
                )
            ),
            array(
                'param-A=valueA&param-B',
                array(
                    'param-A' => 'valueA',
                    'param-B' => '',
                )
            ),
            array(
                'param-A[]=valueA&param-B',
                array(
                    'param-A' => array('valueA'),
                    'param-B' => '',
                )
            ),
            array(
                'param-A[subA]=valueA&param-B',
                array(
                    'param-A' => array('subA' => 'valueA'),
                    'param-B' => '',
                )
            ),

            // With Xpression
            array(
                'query={valueA}',
                array(
                    'query' => 'valueA',
                )
            ),
            array(
                'query[]={valueA}',
                array(
                    'query' => array('valueA'),
                )
            ),
            array(
                'query[subA]={valueA}',
                array(
                    'query' => array('subA' => 'valueA'),
                )
            ),
            array(
                'query-A={valueA}&query-B={valueB}',
                array(
                    'query-A' => 'valueA',
                    'query-B' => 'valueB',
                )
            ),
            array(
                'query-A[]={valueA1}&query-A[]={valueA2}&query-B={valueB}',
                array(
                    'query-A' => array('valueA1', 'valueA2'),
                    'query-B' => 'valueB',
                )
            ),
            array(
                'query-A[subA]={valueA}&query-B={valueB}',
                array(
                    'query-A' => array('subA' => 'valueA'),
                    'query-B' => 'valueB',
                )
            ),

            // Fail
            array(
                'query-A=valueA}',
                array(
                    'query-A' => 'valueA}',
                )
            ),
            array(
                'query-A={valueA',
                array(
                    'query-A' => '{valueA',
                )
            ),
            array(
                'query-A={}valueA',
                array(
                    'query-A' => 'valueA',
                )
            ),
            array(
                'query-A={{valueA}}',
                array(
                    'query-A' => '{valueA}',
                )
            ),
        );
    }

    /**
     * @dataProvider parseDataProvider
     *
     * @param $queryString
     * @param $expectedGET
     */
    public function testParse($queryString, $expectedGET)
    {
        $this->assertEquals($expectedGET, QueryStringParser::parse($queryString));
    }
}
