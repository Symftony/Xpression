<?php

namespace Example;

use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\HtmlExpressionBuilder;
use Symftony\Xpression\Parser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');

$expression = '';
$exception = null;
$parser = new Parser(new HtmlExpressionBuilder());
if (isset($_SERVER['QUERY_STRING'])) {
    $query = urldecode($_SERVER['QUERY_STRING']);
    if ('' !== $query) {
        try {
            $expression = $parser->parse($query);
        } catch (InvalidExpressionException $e) {
            $exception = $e;
        }
    }
}
?>
<html>
<head>
    <title>Xpression : Basic example</title>
</head>
<body>
<?php include 'includes/menu.php'; ?>
<div class="container">
    <h1>Xpression Visualisation</h1>
    <div class="content warning">
        <p>If you want to use Xpression syntax without another query string parameter</p>
        <p>scheme://authority/path?<strong>title='foo'&price>2</strong></p>
        <p></p>
    </div>
    <div class="content code"><pre><code>
    &lt;?php

    use Symftony\Xpression\Parser;
    use Symftony\Xpression\Expr\HtmlExpressionBuilder;

    $parser = new Parser(new HtmlExpressionBuilder());
    $expression = $parser->parse(urldecode($_SERVER['QUERY_STRING']));</code></pre>
    </div>
    <div class="content">
        <ul class="example">
            <li><a href="?">title is null</a></li>
            <li><a href="?title='foo'">title = 'foo'</a></li>
            <li><a href="?price=10">price = 10</a></li>
            <li><a href="?price≠10">price ≠ 10</a></li>
            <li><a href="?price>10">price > 10</a></li>
            <li><a href="?price≥10">price ≥ 10</a></li>
            <li><a href="?price<10">price < 10</a></li>
            <li><a href="?price≤10">price ≤ 10</a></li>
            <li><a href="?price>10&price<20">price > 10 & price < 20</a></li>
            <li><a href="?price=2|category='food'">price=2 | category = 'food'</a></li>
            <li><a href="?price>10&category[1,5,7]">price > 10 & category[1,5,7]</a></li>
            <li><a href="?title=foo|price>3&price<5">title = foo | price > 3 & price < 5</a></li>
            <li><a href="?(title=foo|price>3)&price<5">( title = foo | price > 3 ) & price < 5</a></li>
            <li><a href="?category[1,5,7]">category[1,5,7]</a></li>
            <li><a href="?category![1,5,7]">category![1,5,7]</a></li>
            <li class="error"><a href="?pr$ice">Lexer error</a></li>
            <li class="error"><a href="?price]">Parser error</a></li>
        </ul>
    </div>
    <?php include 'includes/query.php'; ?>
    <?php include 'includes/debug.php'; ?>
</div>
</body>
</html>