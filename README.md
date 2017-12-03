# Xpression

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

Operator | Syntax | Example | ORM | ODM | ArrayCollection |
-------- | ------ | ------- | --- | --- | --------------- |
equal | `=` | `param=value` | X | X | X |
not equal | `!=` `≠` | `param!=value` `param≠value` | X | X | X |
greater than | `>` | `param>value` | X | X | X |
greater than equal | `>=` `≥` | `param>=value` `param≥value` | X | X | X |
less than | `<` | `param<value` | X | X | X |
less than equal | `<=` `≤` | `param<=value` `param≤value` | X | X | X |
less than equal | `<=` `≤` | `param<=value` `param≤value` | X | X | X |
in | `[` `]` | `param[value1,value2]` | X | X | X |
contains | *not yet* | *not yet* |  |  |  |
and | `&` | `param>1&param<10` | X | X | X |
not and | `!&` | `param>1!&param<10` |  | X |  |
or | <code>&#124;</code> | <code>param>1&#124;param<10</code> | X | X | X |
not or | <code>!&#124;</code> | <code>param>1!&#124;param<10</code> |  |  |  |
xor | <code>^&#124;</code> `⊕` | <code>param>1^&#124;param<10</code> `param>1⊕param<10` |  |  |  |

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

### Filter an ArrayCollection

/!\ ArrayCollection doesn't support `not and` `not or` `xor`

These not supported operator was not allowed to use and the parser will throw `ForbiddenTokenException`

```php
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
use Symftony\Xpression\Parser;

$products = new ArrayCollection(
    array(
        array('id' => 1, 'title' => 'banana', 'price' => 2, 'quantity' => 5, 'category' => 'food'),
        array('id' => 2, 'title' => 'banana', 'price' => 5, 'quantity' => 15, 'category' => 'food'),
        array('id' => 3, 'title' => 'apple', 'price' => 1, 'quantity' => 1, 'category' => 'food'),
        array('id' => 4, 'title' => 'TV', 'price' => 399, 'quantity' => 1, 'category' => 'multimedia'),
    )
);

$query = urldecode($_SERVER['QUERY_STRING']);

$parser = new Parser(new ExpressionBuilderAdapter(new ExpressionBuilder()));
$expression = $parser->parse($query);

$filteredProducts = $products->matching(new Criteria($expression));

```

### Create a Doctrine ORM Expression

/!\ ORM Expression doesn't support `not and` `not or` `xor`

These not supported operator was not allowed to use and the parser will throw `ForbiddenTokenException`

```php
use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Parser;

$query = urldecode($_SERVER['QUERY_STRING']);
$parser = new Parser(new ExprAdapter(new Expr()));
$expression = $parser->parse($query);

//$yourQueryBuilder()->where($expression);
```

### Create a Doctrine Mongodb Expression

/!\ ORM Expression doesn't support `not or` `xor`

These not supported operator was not allowed to use and the parser will throw `ForbiddenTokenException`

```php
use Symftony\Xpression\Bridge\Doctrine\MongoDb\ExprBuilder;
use Symftony\Xpression\Parser;

$query = urldecode($_SERVER['QUERY_STRING']);
$parser = new Parser(new ExprBuilder());
$expression = $parser->parse($query);

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

$allowedTokenType = Lexer::T_ALL - Lexer::T_GREATER_THAN_EQUALS - Lexer::T_NOT_EQUALS;
$parser = new Parser(new HtmlExpressionBuilder());
$expression = $parser->parse(url_decode($_SERVER['QUERY_STRING']), $allowedTokenType);

```