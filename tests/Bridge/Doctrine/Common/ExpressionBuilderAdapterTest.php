<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression\Bridge\Doctrine\Common;

use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\ExpressionBuilder;
use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;

/**
 * @internal
 *
 * @coversNothing
 */
final class ExpressionBuilderAdapterTest extends TestCase
{
    private ExpressionBuilderAdapter $expressionBuilderAdapter;

    protected function setUp(): void
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            self::markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }

        $this->expressionBuilderAdapter = new ExpressionBuilderAdapter(new ExpressionBuilder());
    }

    public function testParameter(): void
    {
        self::assertSame('my_fake_data', $this->expressionBuilderAdapter->parameter('my_fake_data'));
    }

    public function testString(): void
    {
        self::assertSame('my_fake_data', $this->expressionBuilderAdapter->string('my_fake_data'));
    }

    public function testIsNull(): void
    {
        $isv0 = !\defined('Doctrine\Common\Collections\Expr\Comparison::CONTAINS');

        $field = 'fake_field';
        self::assertEquals(
            new Comparison('fake_field', $isv0 ? 'IS' : '=', null),
            $this->expressionBuilderAdapter->isNull($field)
        );
    }

    public static function comparisonDataProvider(): iterable
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
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
            new Comparison('field', '=', 'value'),
            $this->expressionBuilderAdapter->eq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNeq(string $field, string $value): void
    {
        self::assertEquals(
            new Comparison('field', '<>', 'value'),
            $this->expressionBuilderAdapter->neq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testGt(string $field, string $value): void
    {
        self::assertEquals(
            new Comparison('field', '>', 'value'),
            $this->expressionBuilderAdapter->gt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testGte(string $field, string $value): void
    {
        self::assertEquals(
            new Comparison('field', '>=', 'value'),
            $this->expressionBuilderAdapter->gte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testLt(string $field, string $value): void
    {
        self::assertEquals(
            new Comparison('field', '<', 'value'),
            $this->expressionBuilderAdapter->lt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testLte(string $field, string $value): void
    {
        self::assertEquals(
            new Comparison('field', '<=', 'value'),
            $this->expressionBuilderAdapter->lte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testIn(string $field, string $value): void
    {
        self::assertEquals(
            new Comparison('field', 'IN', ['value']),
            $this->expressionBuilderAdapter->in($field, [$value])
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNotIn(string $field, string $value): void
    {
        self::assertEquals(
            new Comparison('field', 'NIN', ['value']),
            $this->expressionBuilderAdapter->notIn($field, [$value])
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testContains(string $field, string $value): void
    {
        $expected = new Comparison('field', 'CONTAINS', 'value');

        if (!method_exists('Doctrine\Common\Collections\ExpressionBuilder', 'contains')) {
            $this->expectException(UnsupportedExpressionTypeException::class);
            $this->expectExceptionMessage('Unsupported expression type "contains".');
            $expected = null;
        }

        self::assertEquals(
            $expected,
            $this->expressionBuilderAdapter->contains($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNotContains(string $field, string $value): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->expectExceptionMessage('Unsupported expression type "notContains".');
        $this->expressionBuilderAdapter->notContains($field, $value);
    }

    public static function compositeDataProvider(): iterable
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            return [];
        }

        yield [
            [
                new Comparison('fieldA', '=', 1),
                new Comparison('fieldB', '>', 2),
            ],
        ];
    }

    /**
     * @dataProvider compositeDataProvider
     */
    public function testAndX(array $expressions): void
    {
        self::assertEquals(
            new CompositeExpression('AND', $expressions),
            $this->expressionBuilderAdapter->andX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     */
    public function testNandX(array $expressions): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->expectExceptionMessage('Unsupported expression type "nandX".');
        $this->expressionBuilderAdapter->nandX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     */
    public function testOrX(array $expressions): void
    {
        self::assertEquals(
            new CompositeExpression('OR', $expressions),
            $this->expressionBuilderAdapter->orX($expressions)
        );
    }

    /**
     * @dataProvider compositeDataProvider
     */
    public function testNorX(array $expressions): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->expectExceptionMessage('Unsupported expression type "norX".');
        $this->expressionBuilderAdapter->norX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     */
    public function testXorX(array $expressions): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->expectExceptionMessage('Unsupported expression type "xorX".');
        $this->expressionBuilderAdapter->xorX($expressions);
    }
}
