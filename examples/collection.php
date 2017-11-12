<?php

namespace Example;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Parser;
use Symftony\Xpression\QueryStringParser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');
$_GET = QueryStringParser::parse(urldecode($_SERVER['QUERY_STRING']));

$hasCollection = class_exists('Doctrine\Common\Collections\ExpressionBuilder');

$filteredProducts = array();
$products = array(
    array('id' => 1, 'title' => 'banana', 'price' => 2, 'quantity' => 5, 'category' => 'food'),
    array('id' => 2, 'title' => 'banana', 'price' => 5, 'quantity' => 15, 'category' => 'food'),
    array('id' => 3, 'title' => 'apple', 'price' => 1, 'quantity' => 1, 'category' => 'food'),
    array('id' => 4, 'title' => 'TV', 'price' => 399, 'quantity' => 1, 'category' => 'multimedia'),
);
$filteredIds = array();
$expression = null;
$exception = null;
if ($hasCollection && isset($_GET['query'])) {
    $query = $_GET['query'];
    if ('' !== $query) {
        try {
            $parser = new Parser(new ExpressionBuilderAdapter(new ExpressionBuilder()));
            $expression = $parser->parse($query);
            $products = new ArrayCollection($products);
            $filteredProducts = $products->matching(new Criteria($expression));
            $filteredIds = array_map(function ($product) {
                return $product['id'];
            }, $filteredProducts->toArray());
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
    <h1>Xpression filter ArrayCollection with criteria</h1>
    <?php if (!$hasCollection): ?>
        <div>
            <h2><p class="error">/!\ Error: This example need "<a target="_blank"
                                                                  href="https://github.com/doctrine/collections">doctrine/collections</a>"
                    to work
                </p></h2>
        </div>
    <?php endif ?>
    <?php include 'includes/examples.php'; ?>
    <?php include 'includes/query.php'; ?>
    <div class="content">
        <table class="data">
            <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>category</th>
                <th>quantity</th>
                <th>price</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr style="<?php if (in_array($product['id'], $filteredIds)) echo 'background-color: #ffb566;'; ?>">
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['title']; ?></td>
                    <td><?php echo $product['category']; ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="content info">
        <pre><code><?php print_r($filteredProducts); ?></code></pre>
    </div>
    <?php include 'includes/debug.php'; ?>
    <div class="content code"><pre><code>
    &lt;?php

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Criteria;
    use Doctrine\Common\Collections\ExpressionBuilder;
    use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
    use Symftony\Xpression\Parser;
    use Symftony\Xpression\QueryStringParser;

    $_GET = QueryStringParser::parse(urldecode($_SERVER['QUERY_STRING']));

    $products = array(
        array('id' => 1, 'title' => 'banana', 'price' => 2, 'quantity' => 5, 'category' => 'food'),
        array('id' => 2, 'title' => 'banana', 'price' => 5, 'quantity' => 15, 'category' => 'food'),
        array('id' => 3, 'title' => 'apple', 'price' => 1, 'quantity' => 1, 'category' => 'food'),
        array('id' => 4, 'title' => 'TV', 'price' => 399, 'quantity' => 1, 'category' => 'multimedia'),
    );

    $parser = new Parser(new ExpressionBuilderAdapter(new ExpressionBuilder()));
    $expression = $parser->parse($_GET['query']);
    $products = new ArrayCollection($products);
    $filteredProducts = $products->matching(new Criteria($expression));</code></pre>
    </div>
</body>
</html>