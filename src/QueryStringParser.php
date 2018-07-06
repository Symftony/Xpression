<?php

namespace Symftony\Xpression;

class QueryStringParser
{
    public static function correctServerQueryString()
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            $_SERVER['QUERY_STRING'] = self::encodeXpression($_SERVER['QUERY_STRING']);
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        }
    }

    /**
     * @param $queryString
     *
     * @return string
     */
    public static function encodeXpression($queryString)
    {
        return preg_replace_callback(
            '/(=)\{([^}]*(?:}}[^}]*)*)(?:(?:}(&))|(?:}$))/',
            function ($matches) {
                return $matches[1] . urlencode($matches[2]) . (isset($matches[3]) ? $matches[3] : '');
            }, urldecode($queryString)
        );
    }
}
