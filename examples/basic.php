<?php

namespace Example;

use Symftony\Xpression\Expr\ExpressionBuilder;
use Symftony\Xpression\Parser;

require_once __DIR__ . '/../vendor/autoload.php';

$expression = '';
if (isset($_SERVER['QUERY_STRING'])) {
    $query = urldecode($_SERVER['QUERY_STRING']);
    $parser = new Parser(new ExpressionBuilder());
    $expression = $parser->parse($query);
}
?>
<html>
<head>
    <title>Xpression examples</title>
</head>
<body>
<h2>Parser example</h2>
<ul>
    <li><a href="?title=foo">title = foo</a></li>
    <li><a href="?price=10">price = 10</a></li>
    <li><a href="?price>10">price > 10</a></li>
    <li><a href="?price≥10">price ≥ 10</a></li>
    <li><a href="?price≠10">price ≠ 10</a></li>
    <li><a href="?price>10&price<20">price > 10 & price < 20</a></li>
    <li><a href="?category[1,5,7]">category[1,5,7]</a></li>
    <li><a href="?price>10&category[1,5,7]">price > 10 & category[1,5,7]</a></li>
    <li><a href="?title=foo|price>3&price<5">title = foo | price > 3 & price < 5</a></li>
</ul>
<pre>
    <?php
    print_r($expression);
    ?>
</pre>
</body>
</html>
