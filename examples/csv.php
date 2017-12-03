<?php

namespace Example;

use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\ClosureExpressionBuilder;
use Symftony\Xpression\Expr\MapperExpressionBuilder;
use Symftony\Xpression\Parser;
use Symftony\Xpression\QueryStringParser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');
QueryStringParser::correctServerQueryString();

$expression = '';
$exception = null;
$csvOutput = null;
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    if ('' !== $query) {
        try {
            $csvSource = fopen('./csv/car.csv', 'r');
            $headers = fgetcsv($csvSource);

            $csvOutput = fopen('php://temp', 'w+');
            fputcsv($csvOutput, $headers);

            $parser = new Parser(new MapperExpressionBuilder(new ClosureExpressionBuilder(),
                array_flip($headers)
            ));
            $callback = $parser->parse($query);

            // Filter csv source file and push data to $csvOutput
            while (($data = fgetcsv($csvSource)) !== false) {
                if ($callback($data)) {
                    fputcsv($csvOutput, $data);
                }
            }
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
    <h1>Xpression CSV example</h1>
    <?php include 'includes/examples.php'; ?>
    <?php include 'includes/query.php'; ?>
    <div class="content">
        <pre><code><?php if ($csvOutput) { rewind($csvOutput); echo stream_get_contents($csvOutput); } ?></code></pre>
    </div>
    <?php include 'includes/debug.php'; ?>
    <div class="content code"><pre><code>
    &lt;?php

    use Symftony\Xpression\Parser;
    use Symftony\Xpression\Expr\ClosureExpressionBuilder;
    use Symftony\Xpression\Expr\MapperExpressionBuilder;
    use Symftony\Xpression\QueryStringParser;

    QueryStringParser::correctServerQueryString();

    $csvSource = fopen('./csv/car.csv', 'r');
    $headers = fgetcsv($csvSource);

    $csvOutput = fopen('php://temp', 'w+');
    fputcsv($csvOutput, $headers);

    $parser = new Parser(new MapperExpressionBuilder(new ClosureExpressionBuilder(), array_flip($headers)));
    $callback = $parser->parse($query);

    // Filter csv source file and push data to $csvOutput
    while (($data = fgetcsv($csvSource)) !== false) {
        if ($callback($data)) {
            fputcsv($csvOutput, $data);
        }
    }</code></pre>
    </div>
</div>
</body>
</html>