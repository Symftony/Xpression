<?php

namespace Example;

use Doctrine\Common\EventManager;
use Doctrine\MongoDB\Connection;
use Doctrine\MongoDB\Database;
use Symftony\Xpression\Bridge\Doctrine\MongoDb\ExprBuilder;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Parser;
use Symftony\Xpression\QueryStringParser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');
QueryStringParser::correctServerQueryString();

$hasMongoDb = class_exists('Doctrine\MongoDB\Query\Expr');
$connection = new Connection(getenv('MONGO_HOST'), array(
    'username' => getenv('MONGO_USER'),
    'password' => getenv('MONGO_PASSWORD'),
));
$database = new Database($connection, $connection->{'symftony-xpression'}, new EventManager());
$collection = $database->selectCollection('products');

$expression = '';
$exception = null;
$products = [];

if ($hasMongoDb && isset($_GET['query'])) {
    $query = $_GET['query'];
    if ('' !== $query) {
        try {
            $parser = new Parser(new ExprBuilder());
            $expression = $parser->parse($query);
            $products = $collection->createQueryBuilder()->setQueryArray($expression->getQuery())->getQuery()->execute();
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
                                                                      href="https://github.com/doctrine/mongodb">doctrine/mongodb</a>"to
                        work</p></h2>
            </div>
        </div>
    <?php endif ?>
    <?php include 'includes/examples.php'; ?>
    <?php include 'includes/query.php'; ?>
    <div class="content">
        <table class="data">
            <thead>
            <tr>
                <th>#</th>
                <th>constructor</th>
                <th>model</th>
                <th>year</th>
                <th>price K$</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['constructor']; ?></td>
                    <td><?php echo $product['model']; ?></td>
                    <td><?php echo $product['year']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include 'includes/debug.php'; ?>
    <div class="content code"><pre><code>
    &lt;?php

    use Symftony\Xpression\Parser;
    use Symftony\Xpression\Bridge\Doctrine\MongoDb\ExprBuilder;
    use Symftony\Xpression\QueryStringParser;

    QueryStringParser::correctServerQueryString();

    $parser = new Parser(new ExprBuilder());
    $expression = $parser->parse($_GET['query']);</code></pre>
    </div>
</div>
</body>
</html>