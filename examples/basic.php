<?php

namespace Example;

use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\HtmlExpressionBuilder;
use Symftony\Xpression\Lexer;
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
    <?php include 'includes/examples.php'; ?>
    <?php include 'includes/query.php'; ?>
    <?php include 'includes/debug.php'; ?>
    <div class="content info">
        <p>To use this component you just need to create a parser and give him an ExpressionBuilderInterface</p>
        <p>All accepted token type was</p>
        <ul class="example">
            <?php foreach(Lexer::getTokenSyntax($parser->getAllowedTokenType()) as $tokenSyntax): ?>
                <li><?php echo $tokenSyntax ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="content code"><pre><code>
    &lt;?php

    use Symftony\Xpression\Parser;
    use Symftony\Xpression\Expr\HtmlExpressionBuilder;

    $query = urldecode($_SERVER['QUERY_STRING']);
    $parser = new Parser(new HtmlExpressionBuilder());
    $expression = $parser->parse($query);</code></pre>
    </div>
</div>
</body>
</html>