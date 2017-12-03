<?php

namespace Example;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Tools\Setup;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\MapperExpressionBuilder;
use Symftony\Xpression\Parser;
use Symftony\Xpression\QueryStringParser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');
QueryStringParser::correctServerQueryString();

$hasORM = class_exists('Doctrine\ORM\Query\Expr');
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/Orm/Entity"), true, null, null, false);
$entityManager = EntityManager::create(array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/Orm/products.sqlite',
), $config);

$expression = '';
$exception = null;
$products = [];

if ($hasORM && isset($_GET['query'])) {
    $query = $_GET['query'];
    if ('' !== $query) {
        try {
            $parser = new Parser(new MapperExpressionBuilder(new ExprAdapter(new Expr()), ['*' => 'p.%s']));
            $expression = $parser->parse($query);
            $qb = $entityManager->getRepository('Example\Orm\Entity\Product')->createQueryBuilder('p');
            $DQLquery = $qb->where($expression)->getQuery();
            $products = $DQLquery->execute();
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
                                                                      href="https://github.com/doctrine/doctrine2">doctrine/orm</a>"to
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
                    <td><?php echo $product->getId(); ?></td>
                    <td><?php echo $product->getConstructor(); ?></td>
                    <td><?php echo $product->getModel(); ?></td>
                    <td><?php echo $product->getYear(); ?></td>
                    <td><?php echo $product->getPrice(); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include 'includes/debug.php'; ?>
    <div class="content code"><pre><code>
    &lt;?php

    use Symftony\Xpression\Parser;
    use Doctrine\ORM\Query\Expr;
    use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
    use Symftony\Xpression\QueryStringParser;

    QueryStringParser::correctServerQueryString();

    $parser = new Parser(new ExprAdapter(new Expr()));
    $expression = $parser->parse($_GET['query']);</code></pre>
    </div>
</div>
</body>
</html>