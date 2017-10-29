<?php

namespace Example;

use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\ExpressionBuilderAdapter;
use Symftony\Xpression\Parser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');

$expression = '';
$exception = null;
if (isset($_SERVER['QUERY_STRING'])) {
    $query = urldecode($_SERVER['QUERY_STRING']);
    if ('' !== $query) {
        try {
            $parser = new Parser(new ExpressionBuilderAdapter(new ExpressionBuilder()));
            $expression = $parser->parse($query);
        } catch (InvalidExpressionException $e) {
            $exception = $e;
        }
    }
}
?>
<html>
<head>
    <title>Xpression examples</title>
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
    <h1>Xpression example</h1>
    <div class="content">
        <ul>
            <li><a href="?title='foo'">title = 'foo'</a></li>
            <li><a href="?price=10">price = 10</a></li>
            <li><a href="?price>10">price > 10</a></li>
            <li><a href="?price≥10">price ≥ 10</a></li>
            <li><a href="?price≠10">price ≠ 10</a></li>
            <li><a href="?price>10&price<20">price > 10 & price < 20</a></li>
            <li><a href="?category[1,5,7]">category[1,5,7]</a></li>
            <li><a href="?price>10&category[1,5,7]">price > 10 & category[1,5,7]</a></li>
            <li><a href="?title=foo|price>3&price<5">title = foo | price > 3 & price < 5</a></li>
            <li><a href="?(title=foo|price>3)&price<5">( title = foo | price > 3 ) & price < 5</a></li>
            <li><a href="?pr$ice">Lexer error</a></li>
            <li><a href="?price]">Parser error</a></li>
        </ul>
        <div class="debug">
            <?php if (null !== $exception): ?>
                <div class="exception"><span class="error">throw <?php echo get_class($exception) . ' : ' . $exception->getMessage() ?></span>
                    <?php if (null !== $previousException = $exception->getPrevious()): ?>
                        <div class="exception"><span class="error">throw <?php echo get_class($previousException) . ' : ' . $previousException->getMessage() ?></span></div>
                    <?php endif ?>
                </div>
            <?php endif ?>
            <code>
                <pre><?php print_r($expression); ?></pre>
            </code>
        </div>
    </div>
</div>
</body>
</html>