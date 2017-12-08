<?php

namespace Example;

use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\HtmlExpressionBuilder;
use Symftony\Xpression\Lexer;
use Symftony\Xpression\Parser;
use Symftony\Xpression\QueryStringParser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');
QueryStringParser::correctServerQueryString();

$expression = null;
$exception = null;
$allowedTokenType = Lexer::T_ALL - Lexer::T_GREATER_THAN_EQUALS - Lexer::T_NOT_EQUALS;
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    if ('' !== $query) {
        try {
            $parser = new Parser(new HtmlExpressionBuilder());
            $expression = $parser->parse($query, $allowedTokenType);
        } catch (InvalidExpressionException $e) {
            $exception = $e;
        }
    }
}
?>
<html>
<head>
    <title>Xpression : Disable token type</title>
</head>
<body>
<?php include 'includes/menu.php'; ?>
<div class="container">
    <h1>Xpression : Disable token type</h1>
    <div class="content warning">
        <p>/!\ In this example the operator "≥" and "≠" was not allowed.</p>
        <p>If forbidden token type is use the parser throw InvalidExpression with ForbiddenTokenException</p>
    </div>
    <?php include 'includes/examples.php'; ?>
    <?php include 'includes/query.php'; ?>
    <?php include 'includes/debug.php'; ?>
    <div class="content info">
        <p>If forbidden token type is use the parser throw InvalidExpression with ForbiddenTokenException</p>
    </div>
    <div class="content code"><pre><code>
    &lt;?php

    use Symftony\Xpression\Parser;
    use Symftony\Xpression\Expr\HtmlExpressionBuilder;
    use Symftony\Xpression\Lexer;
    use Symftony\Xpression\QueryStringParser;

    QueryStringParser::correctServerQueryString();

    // I allow all token type except "≥" and "≠"
    $allowedTokenType = Lexer::T_ALL - Lexer::T_GREATER_THAN_EQUALS - Lexer::T_NOT_EQUALS;
    $parser = new Parser(new HtmlExpressionBuilder());
    $expression = $parser->parse($_GET['query'], $allowedTokenType);</code></pre>
    </div>
</div>
</body>
</html>