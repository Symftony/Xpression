<?php

namespace Example;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\ExpressionBuilderAdapter;
use Symftony\Xpression\Parser;

require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');

$products = new ArrayCollection(array(
    array('id' => 1, 'title' => 'banana', 'price' => 2, 'quantity' => 5, 'category' => 'food'),
    array('id' => 2, 'title' => 'banana', 'price' => 5, 'quantity' => 15, 'category' => 'food'),
    array('id' => 3, 'title' => 'apple', 'price' => 1, 'quantity' => 1, 'category' => 'food'),
    array('id' => 4, 'title' => 'TV', 'price' => 399, 'quantity' => 1, 'category' => 'multimedia'),
));
$filteredProducts = array();
$filteredIds = array();
$expression = null;
$exception = null;
if (isset($_SERVER['QUERY_STRING'])) {
    $query = urldecode($_SERVER['QUERY_STRING']);
    if ('' !== $query) {
        try {
            $parser = new Parser(new ExpressionBuilderAdapter(new ExpressionBuilder()));
            $expression = $parser->parse($query);
            $filteredProducts = $products->matching(new Criteria($expression));
            $filteredIds = array_map(function($product){return $product['id'];}, $filteredProducts->toArray());
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
            <li><a href="?title='banana'">title = 'banana'</a></li>
            <li><a href="?price=5">price = 5</a></li>
            <li><a href="?price>2">price > 2</a></li>
            <li><a href="?price≥2">price ≥ 2</a></li>
            <li><a href="?price≠2">price ≠ 2</a></li>
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
            <table>
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
            <code>
                <pre><?php print_r($filteredProducts); ?></pre>
                <pre><?php print_r($expression); ?></pre>
            </code>
        </div>
    </div>
</div>
</body>
</html>