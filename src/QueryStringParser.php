<?php

declare(strict_types=1);

namespace Symftony\Xpression;

class QueryStringParser
{
    public static function correctServerQueryString(): void
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            $_SERVER['QUERY_STRING'] = self::encodeXpression($_SERVER['QUERY_STRING']);
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        }
    }

    /**
     * @return string
     */
    public static function encodeXpression(string $queryString)
    {
        return preg_replace_callback(
            '/(=)\{([^}]*(?:}}[^}]*)*)(?:(?:}(&))|(?:}$))/',
            static fn ($matches) => $matches[1].urlencode($matches[2]).($matches[3] ?? ''),
            urldecode($queryString)
        );
    }
}
