<?php

namespace Tests\Symftony\Xpression\Bridge\Doctrine\Common;

use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;

class ExpressionBuilderAdapterTest extends TestCase
{
    private ExpressionBuilderAdapter $expressionBuilderAdapter;

    public function setUp(): void
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            $this->markTestSkipped('This test is run when you have "doctrine/orm" installed.');
        }

        $this->expressionBuilderAdapter = new ExpressionBuilderAdapter(new ExpressionBuilder());
    }

    public function testParameter(): void
    {
        $this->assertEquals('my_fake_data', $this->expressionBuilderAdapter->parameter('my_fake_data'));
    }

    public function testString(): void
    {
        $this->assertEquals('my_fake_data', $this->expressionBuilderAdapter->string('my_fake_data'));
    }

    public function testIsNull(): void
    {
        $isv0 = !defined('Doctrine\Common\Collections\Expr\Comparison::CONTAINS');

        $field = 'fake_field';
        $this->assertEquals(
            new Comparison('fake_field', $isv0 ? 'IS' : '=', null),
            $this->expressionBuilderAdapter->isNull($field)
        );
    }

    public function comparisonDataProvider(): array
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
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
            new Comparison('field', '=', 'value'),
            $this->expressionBuilderAdapter->eq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNeq(string $field, string $value): void
    {
        $this->assertEquals(
            new Comparison('field', '<>', 'value'),
            $this->expressionBuilderAdapter->neq($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testGt(string $field, string $value): void
    {
        $this->assertEquals(
            new Comparison('field', '>', 'value'),
            $this->expressionBuilderAdapter->gt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testGte(string $field, string $value): void
    {
        $this->assertEquals(
            new Comparison('field', '>=', 'value'),
            $this->expressionBuilderAdapter->gte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testLt(string $field, string $value): void
    {
        $this->assertEquals(
            new Comparison('field', '<', 'value'),
            $this->expressionBuilderAdapter->lt($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testLte(string $field, string $value): void
    {
        $this->assertEquals(
            new Comparison('field', '<=', 'value'),
            $this->expressionBuilderAdapter->lte($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testIn(string $field, string $value): void
    {
        $this->assertEquals(
            new Comparison('field', 'IN', ['value']),
            $this->expressionBuilderAdapter->in($field, [$value])
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNotIn(string $field, string $value): void
    {
        $this->assertEquals(
            new Comparison('field', 'NIN', ['value']),
            $this->expressionBuilderAdapter->notIn($field, [$value])
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testContains(string $field, string $value): void
    {
        if (!method_exists('Doctrine\Common\Collections\ExpressionBuilder', 'contains')) {
            $this->expectException(UnsupportedExpressionTypeException::class);
            $this->expectExceptionMessage('Unsupported expression type "contains".');

            $this->assertNull($this->expressionBuilderAdapter->contains($field, $value));
        }

        $this->assertEquals(
            new Comparison('field', 'CONTAINS', 'value'),
            $this->expressionBuilderAdapter->contains($field, $value)
        );
    }

    /**
     * @dataProvider comparisonDataProvider
     */
    public function testNotContains(string $field, string $value): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->expressionBuilderAdapter->notContains($field, $value);
    }

    public function compositeDataProvider(): array
    {
        if (!class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            return [];
        }

        return [
            [
                [
                    new Comparison('fieldA', '=', 1),
                    new Comparison('fieldB', '>', 2),
                ],
            ],
        ];
    }

    /**
     * @dataProvider compositeDataProvider
     */
    public function testAndX(array $expressions): void
    {
        $this->assertEquals(
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
        $this->expressionBuilderAdapter->nandX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     */
    public function testOrX(array $expressions): void
    {
        $this->assertEquals(
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
        $this->expressionBuilderAdapter->norX($expressions);
    }

    /**
     * @dataProvider compositeDataProvider
     */
    public function testXorX(array $expressions): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->expressionBuilderAdapter->xorX($expressions);
    }
}
