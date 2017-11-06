<?php

namespace Example;

use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\ExpressionBuilderAdapter;
use Symftony\Xpression\Lexer;
use Symftony\Xpression\Parser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');

$expression = null;
$exception = null;
$allowedTokenType = Lexer::T_ALL - Lexer::T_GREATER_THAN_EQUALS - Lexer::T_NOT_EQUALS;
if (isset($_SERVER['QUERY_STRING'])) {
    $query = urldecode($_SERVER['QUERY_STRING']);
    if ('' !== $query) {
        try {
            $parser = new Parser(new ExpressionBuilderAdapter(new ExpressionBuilder()));
            $expression = $parser->parse($query, $allowedTokenType);
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
    <h1>Disable operator expression</h1>
    <div class="content">
        <p class="important">/!\ In this example the operator "≥" and "≠" was not allowed and the parser must throw InvalidExpression with ForbiddenTokenException</p>
    </div>
    <div class="content">
        <ul>
            <li><a href="?title='banana'">title = 'banana'</a></li>
            <li><a href="?price=5">price = 5</a></li>
            <li><a href="?price>2">price > 2</a></li>
            <li><a href="?price≥2">price ≥ 2 (≥ not allowed)</a></li>
            <li><a href="?price≠2">price ≠ 2 (≠ not allowed)</a></li>
            <li><a href="?price>1&price<10">price > 1 & price < 10</a></li>
            <li><a href="?category[food]">category[food]</a></li>
            <li><a href="?price<5&category[food]">price < 5 & category[food]</a></li>
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