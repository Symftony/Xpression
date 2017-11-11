<?php

namespace Example;

use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Parser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');

$hasORM = class_exists('Doctrine\ORM\Query\Expr');

$expression = '';
$exception = null;
if ($hasORM && isset($_SERVER['QUERY_STRING'])) {
    $query = urldecode($_SERVER['QUERY_STRING']);
    if ('' !== $query) {
        try {
            $parser = new Parser(new ExprAdapter(new Expr()));
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
<?php include 'includes/menu.php'; ?>
<div class="container">
    <h1>Xpression doctrine/orm example</h1>
    <?php if (!$hasORM): ?>
        <div class="content">
            <div>
                <h2><p class="error">/!\ Error: This example need "<a target="_blank"
                                                                      href="https://github.com/doctrine/doctrine2">doctrine/orm</a>"
                        to work</p></h2>
            </div>
        </div>
    <?php endif ?>
    <?php include 'includes/examples.php'; ?>
    <?php include 'includes/query.php'; ?>
    <?php include 'includes/debug.php'; ?>
    <div class="content code"><pre><code>
    &lt;?php

    use Symftony\Xpression\Parser;
    use Doctrine\ORM\Query\Expr;
    use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;

    $query = urldecode($_SERVER['QUERY_STRING']);
    $parser = new Parser(new ExprAdapter(new Expr()));
    $expression = $parser->parse($query);
    $expression = $parser->parse($query, $allowedTokenType);</code></pre>
    </div>
</div>
</body>
</html>