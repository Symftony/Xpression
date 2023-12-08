<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\ORM;

use Doctrine\Common\Collections\Expr\Expression;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;

class ExprAdapterTest extends TestCase
{
    /**
     * @var ExprAdapter
     */
    private $exprAdapter;

    public function setUp(): void
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            $this->markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }

        $this->exprAdapter = new ExprAdapter(new Expr());
    }

    public function testIsNull(): void
    {
        $field = 'fake_field';
        $this->assertEquals('fake_field IS NULL', $this->exprAdapter->isNull($field));
    }

    public function comparisonDataProvider()
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return [];
        }

        return [
            ['field', 'value'],
        ];
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testEq(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Comparison($field, Expr\Comparison::EQ, $value),
            $this->exprAdapter->eq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNeq(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Comparison($field, Expr\Comparison::NEQ, $value),
            $this->exprAdapter->neq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testGt(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Comparison($field, Expr\Comparison::GT, $value),
            $this->exprAdapter->gt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testGte(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Comparison($field, Expr\Comparison::GTE, $value),
            $this->exprAdapter->gte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testLt(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Comparison($field, Expr\Comparison::LT, $value),
            $this->exprAdapter->lt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testLte(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Comparison($field, Expr\Comparison::LTE, $value),
            $this->exprAdapter->lte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testIn(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Func('field IN', ["'value'"]),
            $this->exprAdapter->in($field, [$value])
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNotIn(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Func('field NOT IN', ["'value'"]),
            $this->exprAdapter->notIn($field, [$value])
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testContains(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Comparison('field', 'LIKE', $value),
            $this->exprAdapter->contains($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNotContains(string $field, string $value): void
    {
        $this->assertEquals(
            new Expr\Comparison('field', 'NOT LIKE', $value),
            $this->exprAdapter->notContains($field, $value)
        );
    }

    public function compositeDataProvider(): array
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return [];
        }

        return [
            [[
                new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
            ]],
            [[
                new Expr\Func('field', ['value']),
            ]],
            [[
                new Expr\Andx(
                    [
                        new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
                    ]
                ),
            ]],
            [[
                new Expr\Orx(
                    [
                        new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
                    ]
                ),
            ]],
        ];
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param Expression[] $expressions
     */
    public function testAndX(array $expressions): void
    {
        $this->assertEquals(
            new Expr\Andx($expressions),
            $this->exprAdapter->andX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param Expression[] $expressions
     */
    public function testNandX(array $expressions): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->exprAdapter->nandX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param Expression[] $expressions
     */
    public function testOrX(array $expressions): void
    {
        $this->assertEquals(
            new Expr\Orx($expressions),
            $this->exprAdapter->orX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param Expression[] $expressions
     */
    public function testNorX(array $expressions): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->exprAdapter->norX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param Expression[] $expressions
     */
    public function testXorX(array $expressions): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->exprAdapter->xorX($expressions);
    }
}
