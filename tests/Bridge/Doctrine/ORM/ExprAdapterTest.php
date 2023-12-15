<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression\Bridge\Doctrine\ORM;

use Doctrine\Common\Collections\Expr\Expression;
use Doctrine\ORM\Query\Expr;
use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;

/**
 * @internal
 *
 * @coversNothing
 */
final class ExprAdapterTest extends TestCase
{
    private ExprAdapter $exprAdapter;

    protected function setUp(): void
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            self::markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }

        $this->exprAdapter = new ExprAdapter(new Expr());
    }

    public function testIsNull(): void
    {
        $field = 'fake_field';
        self::assertSame('fake_field IS NULL', $this->exprAdapter->isNull($field));
    }

    public static function comparisonDataProvider(): iterable
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return [];
        }

        yield ['field', 'value'];
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testEq(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Comparison($field, Expr\Comparison::EQ, $value),
            $this->exprAdapter->eq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNeq(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Comparison($field, Expr\Comparison::NEQ, $value),
            $this->exprAdapter->neq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testGt(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Comparison($field, Expr\Comparison::GT, $value),
            $this->exprAdapter->gt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testGte(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Comparison($field, Expr\Comparison::GTE, $value),
            $this->exprAdapter->gte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testLt(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Comparison($field, Expr\Comparison::LT, $value),
            $this->exprAdapter->lt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testLte(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Comparison($field, Expr\Comparison::LTE, $value),
            $this->exprAdapter->lte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testIn(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Func('field IN', ["'value'"]),
            $this->exprAdapter->in($field, [$value])
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNotIn(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Func('field NOT IN', ["'value'"]),
            $this->exprAdapter->notIn($field, [$value])
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testContains(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Comparison('field', 'LIKE', $value),
            $this->exprAdapter->contains($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNotContains(string $field, string $value): void
    {
        self::assertEquals(
            new Expr\Comparison('field', 'NOT LIKE', $value),
            $this->exprAdapter->notContains($field, $value)
        );
    }

    public static function compositeDataProvider(): iterable
    {
        if (!class_exists('Doctrine\ORM\Query\Expr')) {
            return [];
        }

        yield [[
            new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
        ]];

        yield [[
            new Expr\Func('field', ['value']),
        ]];

        yield [[
            new Expr\Andx(
                [
                    new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
                ]
            ),
        ]];

        yield [[
            new Expr\Orx(
                [
                    new Expr\Comparison('field', Expr\Comparison::EQ, 'value'),
                ]
            ),
        ]];
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param Expression[] $expressions
     */
    public function testAndX(array $expressions): void
    {
        self::assertEquals(
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
        $this->expectExceptionMessage('Unsupported expression type "nandX".');
        $this->exprAdapter->nandX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     *
     * @param Expression[] $expressions
     */
    public function testOrX(array $expressions): void
    {
        self::assertEquals(
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
        $this->expectExceptionMessage('Unsupported expression type "norX".');
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
        $this->expectExceptionMessage('Unsupported expression type "xorX".');
        $this->exprAdapter->xorX($expressions);
    }
}
