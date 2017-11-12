<?php

namespace Symftony\Xpression;

class QueryStringParser
{
    /**
     * @param $queryString
     *
     * @return array
     */
    static public function parse($queryString)
    {
        parse_str(preg_replace_callback('/\{(\S*)\}/U', function ($matches) {
            return urlencode($matches[1]);
        }, $queryString), $GET);

        return $GET;
    }
}