<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', '1');

require '/app/vendor/autoload.php';

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\DriverManager;
use Doctrine\Common\Collections\ExpressionBuilder;
use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Expr\ClosureExpressionBuilder;
use Symftony\Xpression\Expr\HtmlExpressionBuilder;
use Symftony\Xpression\Parser;

$query = trim(file_get_contents('/app/query.txt'));
$mode = trim(file_get_contents('/app/mode.txt'));

$products = array(
    array('id' => 1, 'constructor' => 'Volkswagen', 'model' => 'Golf', 'year' => 1990, 'price' => 11),
    array('id' => 2, 'constructor' => 'Volkswagen', 'model' => 'Rabbit', 'year' => 2009, 'price' => 7),
    array('id' => 3, 'constructor' => 'Cadillac', 'model' => 'Catera', 'year' => 1999, 'price' => 5),
    array('id' => 4, 'constructor' => 'Ford', 'model' => 'Mustang', 'year' => 1970, 'price' => 4),
    array('id' => 5, 'constructor' => 'Ford', 'model' => 'Laser', 'year' => 1989, 'price' => 2),
    array('id' => 6, 'constructor' => 'Lexus', 'model' => 'LS', 'year' => 2007, 'price' => 18),
    array('id' => 7, 'constructor' => 'Lexus', 'model' => 'LX', 'year' => 1999, 'price' => 4),
    array('id' => 8, 'constructor' => 'Hyundai', 'model' => 'Sonata', 'year' => 1996, 'price' => 13),
    array('id' => 9, 'constructor' => 'Land Rover', 'model' => 'Discovery', 'year' => 2002, 'price' => 20),
    array('id' => 10, 'constructor' => 'Mitsubishi', 'model' => 'Eclipse', 'year' => 2001, 'price' => 8),
);

$readCsv = function ($file) {
    $rows = array();
    $header = null;
    foreach (preg_split('/\r?\n/', trim(file_get_contents($file))) as $line) {
        $cells = str_getcsv($line, ',', '"', '');
        if (null === $header) {
            $header = $cells;
            continue;
        }
        $row = array_combine($header, array_pad($cells, count($header), ''));
        foreach ($row as $key => $value) {
            if (is_numeric($value)) {
                $row[$key] = $value + 0;
            }
        }
        $rows[] = $row;
    }

    return $rows;
};

// An empty expression means no filter: every row matches.
$parse = function ($builder) use ($query) {
    return '' === $query ? null : (new Parser($builder))->parse($query);
};

$result = array();
try {
    // The default HtmlExpressionBuilder templates do not escape: escape everything before it reaches innerHTML.
    $e = function ($value) {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    };
    $htmlBuilder = new HtmlExpressionBuilder(
        function ($field, $operator, $value) use ($e) {
            return sprintf('<div>%s %s %s</div>', $e($field), $e($operator), $e($value));
        },
        function (array $expressions, $type) use ($e) {
            return '<fieldset><legend>' . $e($type) . '</legend>' . implode('', $expressions) . '</fieldset>';
        }
    );
    $result['html'] = '' === $query ? '' : $parse($htmlBuilder);

    switch ($mode) {
        case 'array':
            $filter = $parse(new ClosureExpressionBuilder());
            $result['rows'] = $filter ? array_values(array_filter($products, $filter)) : $products;
            break;
        case 'csv':
            $filter = $parse(new ClosureExpressionBuilder());
            $rows = $readCsv('/app/data.csv');
            $result['rows'] = $filter ? array_values(array_filter($rows, $filter)) : $rows;
            break;
        case 'collection':
            $expression = $parse(new ExpressionBuilderAdapter(new ExpressionBuilder()));
            $result['rows'] = array_values(
                (new ArrayCollection($products))->matching(new Criteria($expression))->toArray()
            );
            break;
        case 'orm':
            $expression = $parse(new ExprAdapter(new Expr()));
            $result['dql'] = (string) $expression;
            if (!extension_loaded('pdo_sqlite')) {
                $result['sqlError'] = 'pdo_sqlite is not available in this runtime.';
                break;
            }
            try {
                $conn = DriverManager::getConnection(array('driver' => 'pdo_sqlite', 'memory' => true));
                $conn->executeStatement('CREATE TABLE product (id INTEGER PRIMARY KEY, constructor TEXT, model TEXT, year INTEGER, price INTEGER)');
                foreach ($products as $product) {
                    $conn->insert('product', $product);
                }
                $qb = $conn->createQueryBuilder()->select('*')->from('product');
                if (null !== $expression) {
                    $qb->where($expression);
                }
                $result['sql'] = $qb->getSQL();
                $result['rows'] = $qb->executeQuery()->fetchAllAssociative();
            } catch (\Throwable $e) {
                $result['sqlError'] = get_class($e) . ': ' . $e->getMessage();
            }
            break;
    }
} catch (\Throwable $e) {
    $result = array('error' => get_class($e) . ': ' . $e->getMessage());
}

echo json_encode($result);
