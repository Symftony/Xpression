<?php

namespace Symftony\Xpression;

class QueryStringParser
{
    static public function correctServerQueryString()
    {
        $_SERVER['QUERY_STRING'] = self::encodeXpression($_SERVER['QUERY_STRING']);
        parse_str($_SERVER['QUERY_STRING'], $_GET);
    }

    /**
     * @param $queryString
     *
     * @return string
     */
    static public function encodeXpression($queryString)
    {
        return preg_replace_callback('/\{(\S*)\}/U', function($matches) {
            return urlencode($matches[1]);
        }, urldecode($queryString));
    }
}