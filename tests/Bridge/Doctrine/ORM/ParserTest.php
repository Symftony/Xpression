<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression\Bridge\Doctrine\ORM;

use Doctrine\ORM\Query\Expr;
use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Parser;

/**
 * @internal
 *
 * @coversNothing
 */
final class ParserTest extends TestCase
{
    private ExprAdapter $exprAdapter;

    private Parser $parser;

    protected function setUp(): void
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            self::markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }
        $this->exprAdapter = new ExprAdapter(new Expr());
        $this->parser = new Parser($this->exprAdapter);
    }

    public static function provideParserCases(): iterable
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return [];
        }

        yield [
            'fieldA=1',
            new Expr\Comparison('fieldA', '=', 1),
        ];

        yield [
            'fieldA="string"',
            new Expr\Comparison('fieldA', '=', (new Expr())->literal('string')),
        ];

        yield [
            'fieldA≥1',
            new Expr\Comparison('fieldA', '>=', 1),
        ];

        yield [
            'fieldA>=1',
            new Expr\Comparison('fieldA', '>=', 1),
        ];

        yield [
            'fieldA≤1',
            new Expr\Comparison('fieldA', '<=', 1),
        ];

        yield [
            'fieldA<=1',
            new Expr\Comparison('fieldA', '<=', 1),
        ];

        yield [
            'fieldA≠1',
            new Expr\Comparison('fieldA', '<>', 1),
        ];

        yield [
            'fieldA!=1',
            new Expr\Comparison('fieldA', '<>', 1),
        ];

        yield [
            'fieldA[1,2]',
            new Expr\Func('fieldA IN', [1, 2]),
        ];

        yield [
            'fieldA![1,2]',
            new Expr\Func('fieldA NOT IN', [1, 2]),
        ];

        yield [
            'fieldA{{1}}',
            new Expr\Comparison('fieldA', 'LIKE', 1),
        ];

        yield [
            'fieldA!{{1}}',
            new Expr\Comparison('fieldA', 'NOT LIKE', 1),
        ];

        yield [
            'fieldA=1|fieldB=2|fieldC=3',
            new Expr\Orx([
                new Expr\Comparison('fieldA', '=', 1),
                new Expr\Comparison('fieldB', '=', 2),
                new Expr\Comparison('fieldC', '=', 3),
            ]),
        ];

        yield [
            'fieldA=1&fieldB=2&fieldC=3',
            new Expr\Andx([
                new Expr\Comparison('fieldA', '=', 1),
                new Expr\Comparison('fieldB', '=', 2),
                new Expr\Comparison('fieldC', '=', 3),
            ]),
        ];

        // Precedences
        yield [
            'fieldA=1|fieldB=2|fieldC=3&fieldD=4',
            new Expr\Orx([
                new Expr\Comparison('fieldA', '=', 1),
                new Expr\Comparison('fieldB', '=', 2),
                new Expr\Andx([
                    new Expr\Comparison('fieldC', '=', 3),
                    new Expr\Comparison('fieldD', '=', 4),
                ]),
            ]),
        ];

        yield [
            'fieldA=1&fieldB=2&fieldC=3|fieldD=4',
            new Expr\Orx([
                new Expr\Andx([
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                    new Expr\Comparison('fieldC', '=', 3),
                ]),
                new Expr\Comparison('fieldD', '=', 4),
            ]),
        ];

        yield [
            'fieldA=1&fieldB=2|fieldC=3&fieldD=4',
            new Expr\Orx([
                new Expr\Andx([
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                ]),
                new Expr\Andx([
                    new Expr\Comparison('fieldC', '=', 3),
                    new Expr\Comparison('fieldD', '=', 4),
                ]),
            ]),
        ];

        // Parenthesis
        yield [
            '((fieldA=1))',
            new Expr\Comparison('fieldA', '=', 1),
        ];

        yield [
            '(fieldA=1|fieldB=2)&fieldC=3',
            new Expr\Andx([
                new Expr\Orx([
                    new Expr\Comparison('fieldA', '=', 1),
                    new Expr\Comparison('fieldB', '=', 2),
                ]),
                new Expr\Comparison('fieldC', '=', 3),
            ]),
        ];

        yield [
            'fieldA=1|(fieldB=2&fieldC=3)',
            new Expr\Orx([
                new Expr\Comparison('fieldA', '=', 1),
                new Expr\Andx([
                    new Expr\Comparison('fieldB', '=', 2),
                    new Expr\Comparison('fieldC', '=', 3),
                ]),
            ]),
        ];
    }

    /**
     * @dataProvider provideParserCases
     *
     * @param mixed $expectedExpression
     */
    public function testParser(string $input, $expectedExpression): void
    {
        self::assertEquals($expectedExpression, $this->parser->parse($input));
    }

    public static function provideParserThrowUnsupportedExpressionTypeExceptionCases(): iterable
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return [];
        }

        yield ['fieldA=1!|fieldB=2!|fieldC=3'];

        yield ['fieldA=1^|fieldB=2'];

        yield ['fieldA=1⊕fieldB=2'];

        yield ['fieldA=1!&fieldB=2!&fieldC=3'];

        yield ['fieldA=1&fieldB=2&fieldC=3!&fieldD=4'];

        yield ['fieldA=1|fieldB=2|fieldC=3!|fieldD=4'];

        yield ['fieldA=1|fieldB=2|fieldC=3⊕fieldD=4'];
    }

    /**
     * @dataProvider provideParserThrowUnsupportedExpressionTypeExceptionCases
     */
    public function testParserThrowUnsupportedExpressionTypeException(string $input): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->expectExceptionMessage('Invalid expression.');
        $this->parser->parse($input);
    }
}
