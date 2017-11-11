<?php

namespace Example;

use Symftony\Xpression\Bridge\Doctrine\MongoDb\ExprBuilder;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Parser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');

$hasMongoDb = class_exists('Doctrine\MongoDB\Query\Expr');

$expression = '';
$exception = null;
if ($hasMongoDb && isset($_SERVER['QUERY_STRING'])) {
    $query = urldecode($_SERVER['QUERY_STRING']);
    if ('' !== $query) {
        try {
            $parser = new Parser(new ExprBuilder());
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
    <h1>Xpression doctrine/mongodb example</h1>
    <?php if (!$hasMongoDb): ?>
        <div class="content">
            <div>
                <h2><p class="error">/!\ Error: This example need "<a target="_blank"
                                                                      href="https://github.com/doctrine/mongodb">doctrine/mongodb</a>"
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
    use Symftony\Xpression\Bridge\Doctrine\MongoDb\ExprBuilder;

    $query = urldecode($_SERVER['QUERY_STRING']);
    $parser = new Parser(new ExprBuilder());
    $expression = $parser->parse($query);</code></pre>
    </div>
</div>
</body>
</html>