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
    <title>Xpression : Query string</title>
</head>
<body>
<?php include 'includes/menu.php'; ?>
<div class="container">
    <h1>Xpression : Query string</h1>
    <div class="content warning">
        <p>If you want to use Xpression syntax without another query string parameter</p>
        <p>scheme://authority/path?<strong>price>5&price<14</strong></p>
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
            <li><a href="?constructor='Lexus'">constructor = 'Lexus'</a></li>
            <li><a href="?price=13">price = 13</a></li>
            <li><a href="?price≠5">price ≠ 5</a></li>
            <li><a href="?price>5">price > 5</a></li>
            <li><a href="?price≥5">price ≥ 5</a></li>
            <li><a href="?price<5">price < 5</a></li>
            <li><a href="?price≤5">price ≤ 5</a></li>
            <li><a href="?price>5&price<14">price > 5 & price < 14</a></li>
            <li><a href="?price>5&price<14|constructor='Lexus'">price > 5 & price < 14 | constructor = 'Lexus'</a></li>
            <li><a href="?year[1990,1996,2006]">year [1990,1996,2006]</a></li>
            <li><a href="?constructor='Lexus'&price≥4|price≤17">constructor = 'Lexus' & price ≥ 4 | price ≤ 17</a></li>
            <li><a href="?constructor='Lexus'&(price≥4|price≤17)">constructor = 'Lexus' & (price ≥ 4 | price ≤ 17)</a></li>
            <li class="error"><a href="?pr$ice">Lexer error</a></li>
            <li class="error"><a href="?price]">Parser error</a></li>
        </ul>
    </div>
    <?php include 'includes/query.php'; ?>
    <?php include 'includes/debug.php'; ?>
</div>
</body>
</html>