# Xpression

[![Codecov](https://img.shields.io/codecov/c/github/Symftony/Xpression.svg?style=flat)]()
[![Travis branch](https://img.shields.io/travis/Symftony/Xpression.svg?style=flat)]()
[![Scrutinizer](https://img.shields.io/scrutinizer/g/Symftony/Xpression.svg?style=flat)]()
[![Latest Unstable Version](https://poser.pugx.org/symftony/xpression/v/unstable)](https://packagist.org/packages/symftony/xpression)
[![Latest Stable Version](https://poser.pugx.org/symftony/xpression/v/stable)](https://packagist.org/packages/symftony/xpression)
[![Total Downloads](https://poser.pugx.org/symftony/xpression/downloads)](https://packagist.org/packages/symftony/xpression)
[![License](https://poser.pugx.org/symftony/xpression/license)](https://packagist.org/packages/symftony/xpression)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/38d47cff-1abb-4083-a537-5794d9a9b281/mini.png)](https://insight.sensiolabs.com/projects/38d47cff-1abb-4083-a537-5794d9a9b281)

**Xpression** is a simple PHP implementation of **Specification pattern**.   

## Demo

You can try this library on [Demo Xpression](http://symftony-xpression.herokuapp.com/)

## Installation

The recommended way to install **Xpression** is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

```bash
php composer require symftony/xpression
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## Documentation

This library provide:

- lexer that tokenise your query
- parser that use tokens and ExpressionBuilder to create the target Expression
- a query string parser to correctly fix and parse the *$_SERVER['QUERY_STRING']* into *$_GET* 

### Supported query operator

Operator | Syntax | Example | ORM | ODM | ArrayCollection | Closure |
-------- | ------ | ------- | --- | --- | --------------- | ------- |
equal | `=` | `param=value` | X | X | X | X |
not equal | `!=` `≠` | `param!=value` `param≠value` | X | X | X | X |
greater than | `>` | `param>value` | X | X | X | X |
greater than equal | `>=` `≥` | `param>=value` `param≥value` | X | X | X | X |
less than | `<` | `param<value` | X | X | X | X |
less than equal | `<=` `≤` | `param<=value` `param≤value` | X | X | X | X |
less than equal | `<=` `≤` | `param<=value` `param≤value` | X | X | X | X |
in | `[` `]` | `param[value1,value2]` | X | X | X | X |
contains | `{{` `}}` | `param{{value}}` | X | X |  | X |
not contains | `!{{` `}}` | `param!{{value}}` | X | X |  | X |
and | `&` | `param>1&param<10` | X | X | X | X |
not and | `!&` | `param>1!&param<10` |  | X |  | X |
or | <code>&#124;</code> | <code>param>1&#124;param<10</code> | X | X | X | X |
not or | <code>!&#124;</code> | <code>param>1!&#124;param<10</code> |  |  |  | X |
xor | <code>^&#124;</code> `⊕` | <code>param>1^&#124;param<10</code> `param>1⊕param<10` |  |  |  | X |

### The composite operator precedence

The highest was compute before the lowest

- and: 15
- not and: 14
- or: 10
- xor: 9
- not or: 8

if you want to force a certain order of computation use the group syntax with `(` `)`

This expression search title 'Bar' with 'price' under '5' or title 'Foo'

`title='Foo'|title='Bar'&price<5` is equal to `title='Foo'|(title='Bar'&price<5)`
 
The next one search the title 'Foo' or 'Bar' with 'price' less than '5'
 
`(title='Foo'|title='Bar')&price<5` 

## Use 

### Filter an array

```php
use Symftony\Xpression\Expr\ClosureExpressionBuilder;
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

$parser = new Parser(new ClosureExpressionBuilder());
$expression = $parser->parse($_GET['query']);
$filteredProducts = array_filter($products, $expression);

```

### Filter an ArrayCollection

/!\ ArrayCollection doesn't support `not and` `not or` `xor` `contains` `not contains`

These not supported operator was not allowed to use and the parser will throw `UnsupportedTokenTypeException`

```php
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
use Symftony\Xpression\Parser;

QueryStringParser::correctServerQueryString();

$products = new ArrayCollection(
    array(
        array('id' => 1, 'title' => 'banana', 'price' => 2, 'quantity' => 5, 'category' => 'food'),
        array('id' => 2, 'title' => 'banana', 'price' => 5, 'quantity' => 15, 'category' => 'food'),
        array('id' => 3, 'title' => 'apple', 'price' => 1, 'quantity' => 1, 'category' => 'food'),
        array('id' => 4, 'title' => 'TV', 'price' => 399, 'quantity' => 1, 'category' => 'multimedia'),
    )
);

$parser = new Parser(new ExpressionBuilderAdapter(new ExpressionBuilder()));
$expression = $parser->parse($_GET['query']);

$filteredProducts = $products->matching(new Criteria($expression));

```

### Create a Doctrine ORM Expression

/!\ ORM Expression doesn't support `not and` `not or` `xor`

These not supported operator was not allowed to use and the parser will throw `UnsupportedTokenTypeException`

```php
use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Parser;

QueryStringParser::correctServerQueryString();

$parser = new Parser(new ExprAdapter(new Expr()));
$expression = $parser->parse($_GET['query']);

//$yourQueryBuilder()->where($expression);
```

### Create a Doctrine Mongodb Expression

/!\ ORM Expression doesn't support `not or` `xor`

These not supported operator was not allowed to use and the parser will throw `UnsupportedTokenTypeException`

```php
use Symftony\Xpression\Bridge\Doctrine\MongoDb\ExprBuilder;
use Symftony\Xpression\Parser;

QueryStringParser::correctServerQueryString();

$parser = new Parser(new ExprBuilder());
$expression = $parser->parse($_GET['query']);

//$yourQueryBuilder()->where($expression);
```

### You can disable token type 

If you want disable an operator you can disable it manually
The parser will throw `ForbiddenTokenException`

By default all token type was allowed `Lexer::ALL`

but when you call `$parser->parse($query, $allowedToken)`

Example to disable the greater than equal `≥` and the not equal `≠`
 
```php
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Expr\HtmlExpressionBuilder;
use Symftony\Xpression\Lexer;
use Symftony\Xpression\Parser;
use Symftony\Xpression\QueryStringParser;

QueryStringParser::correctServerQueryString();

$allowedTokenType = Lexer::T_ALL - Lexer::T_GREATER_THAN_EQUALS - Lexer::T_NOT_EQUALS;
$parser = new Parser(new HtmlExpressionBuilder());
$expression = $parser->parse($_GET['query']), $allowedTokenType);

```
