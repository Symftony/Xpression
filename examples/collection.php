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
QueryStringParser::correctServerQueryString();

$hasCollection = class_exists('Doctrine\Common\Collections\ExpressionBuilder');

$filteredProducts = array();
$products = array(
    array('id' => 1, 'constructor' => 'Volkswagen', 'model' => 'Golf', 'year' => 1990, 'price' => 11),
    array('id' => 2, 'constructor' => 'Volkswagen', 'model' => 'Rabbit', 'year' => 2009, 'price' => 7),
    array('id' => 3, 'constructor' => 'Volkswagen', 'model' => 'Rabbit', 'year' => 2006, 'price' => 12),
    array('id' => 4, 'constructor' => 'Cadillac', 'model' => 'Catera', 'year' => 1999, 'price' => 5),
    array('id' => 5, 'constructor' => 'Cadillac', 'model' => 'STS', 'year' => 2006, 'price' => 14),
    array('id' => 6, 'constructor' => 'Ford', 'model' => 'Mustang', 'year' => 1970, 'price' => 4),
    array('id' => 7, 'constructor' => 'Ford', 'model' => 'Laser', 'year' => 1989, 'price' => 2),
    array('id' => 8, 'constructor' => 'Ford', 'model' => 'Bronco II', 'year' => 1990, 'price' => 13),
    array('id' => 9, 'constructor' => 'Lexus', 'model' => 'LS', 'year' => 2007, 'price' => 18),
    array('id' => 10, 'constructor' => 'Lexus', 'model' => 'LS', 'year' => 2000, 'price' => 17),
    array('id' => 11, 'constructor' => 'Lexus', 'model' => 'LX', 'year' => 1999, 'price' => 4),
    array('id' => 12, 'constructor' => 'Hyundai', 'model' => 'Sonata', 'year' => 1996, 'price' => 13),
    array('id' => 13, 'constructor' => 'Hyundai', 'model' => 'XG350', 'year' => 2002, 'price' => 5),
    array('id' => 14, 'constructor' => 'Land Rover', 'model' => 'Discovery SeriesII', 'year' => 2000, 'price' => 17),
    array('id' => 15, 'constructor' => 'Land Rover', 'model' => 'Discovery', 'year' => 2002, 'price' => 20),
    array('id' => 16, 'constructor' => 'Oldsmobile Cutlass', 'model' => 'Supreme', 'year' => 1992, 'price' => 5),
    array('id' => 17, 'constructor' => 'Mitsubishi', 'model' => 'Eclipse', 'year' => 2001, 'price' => 8),
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
            <h2><p class="error">/!\ Error: This example need "<a target="_blank" href="https://github.com/doctrine/collections">doctrine/collections</a>"to work</p></h2>
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
                <tr style="<?php if (in_array($product['id'], $filteredIds)) echo 'background-color: #ffb566;'; ?>">
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
    <div class="content info">
        <pre><code><?php print_r($filteredProducts); ?></code></pre>
    </div>
    <div class="content code"><pre><code>
    &lt;?php

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Criteria;
    use Doctrine\Common\Collections\ExpressionBuilder;
    use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
    use Symftony\Xpression\Parser;
    use Symftony\Xpression\QueryStringParser;

    QueryStringParser::correctServerQueryString();

    $products = array(
        array('id' => 1, 'constructor' => 'Volkswagen', 'model' => 'Golf', 'year' => 1990, 'price' => 11),
        array('id' => 2, 'constructor' => 'Volkswagen', 'model' => 'Rabbit', 'year' => 2009, 'price' => 7),
        array('id' => 3, 'constructor' => 'Volkswagen', 'model' => 'Rabbit', 'year' => 2006, 'price' => 12),
        array('id' => 4, 'constructor' => 'Cadillac', 'model' => 'Catera', 'year' => 1999, 'price' => 5),
        array('id' => 5, 'constructor' => 'Cadillac', 'model' => 'STS', 'year' => 2006, 'price' => 14),
        array('id' => 6, 'constructor' => 'Ford', 'model' => 'Mustang', 'year' => 1970, 'price' => 4),
        array('id' => 7, 'constructor' => 'Ford', 'model' => 'Laser', 'year' => 1989, 'price' => 2),
        array('id' => 8, 'constructor' => 'Ford', 'model' => 'Bronco II', 'year' => 1990, 'price' => 3),
        array('id' => 9, 'constructor' => 'Lexus', 'model' => 'LS', 'year' => 2007, 'price' => 18),
        array('id' => 10, 'constructor' => 'Lexus', 'model' => 'LS', 'year' => 2000, 'price' => 17),
        array('id' => 11, 'constructor' => 'Lexus', 'model' => 'LX', 'year' => 1999, 'price' => 4),
        array('id' => 12, 'constructor' => 'Hyundai', 'model' => 'Sonata', 'year' => 1996, 'price' => 13),
        array('id' => 13, 'constructor' => 'Hyundai', 'model' => 'XG350', 'year' => 2002, 'price' => 5),
        array('id' => 14, 'constructor' => 'Land Rover', 'model' => 'Discovery SeriesII', 'year' => 2000, 'price' => 17),
        array('id' => 15, 'constructor' => 'Land Rover', 'model' => 'Discovery', 'year' => 2002, 'price' => 20),
        array('id' => 16, 'constructor' => 'Oldsmobile Cutlass', 'model' => 'Supreme', 'year' => 1992, 'price' => 3),
        array('id' => 17, 'constructor' => 'Mitsubishi', 'model' => 'Eclipse', 'year' => 2001, 'price' => 8),
    );

    $parser = new Parser(new ExpressionBuilderAdapter(new ExpressionBuilder()));
    $expression = $parser->parse($_GET['query']);
    $products = new ArrayCollection($products);
    $filteredProducts = $products->matching(new Criteria($expression));</code></pre>
    </div>
</body>
</html>