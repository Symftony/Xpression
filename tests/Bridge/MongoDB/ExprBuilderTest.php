<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression\Bridge\MongoDB;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\MongoDB\ExprBuilder;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Lexer;

/**
 * @internal
 *
 * @coversNothing
 */
final class ExprBuilderTest extends TestCase
{
    private ExprBuilder $exprAdapter;

    protected function setUp(): void
    {
        $this->exprAdapter = new ExprBuilder();
    }

    public function testGetSupportedTokenType(): void
    {
        self::assertSame(Lexer::T_ALL - Lexer::T_XOR, $this->exprAdapter->getSupportedTokenType());
    }

    public function testIsNull(): void
    {
        $field = 'fake_field';
        self::assertSame(['fake_field' => null], $this->exprAdapter->isNull($field));
    }

    public function testEq(): void
    {
        self::assertSame(
            ['fieldA' => ['$eq' => 1]],
            $this->exprAdapter->eq('fieldA', 1)
        );
    }

    public function testNeq(): void
    {
        self::assertSame(
            ['fieldA' => ['$ne' => 1]],
            $this->exprAdapter->neq('fieldA', 1)
        );
    }

    public function testGt(): void
    {
        self::assertSame(
            ['fieldA' => ['$gt' => 1]],
            $this->exprAdapter->gt('fieldA', 1)
        );
    }

    public function testGte(): void
    {
        self::assertSame(
            ['fieldA' => ['$gte' => 1]],
            $this->exprAdapter->gte('fieldA', 1)
        );
    }

    public function testLt(): void
    {
        self::assertSame(
            ['fieldA' => ['$lt' => 1]],
            $this->exprAdapter->lt('fieldA', 1)
        );
    }

    public function testLte(): void
    {
        self::assertSame(
            ['fieldA' => ['$lte' => 1]],
            $this->exprAdapter->lte('fieldA', 1)
        );
    }

    public function testIn(): void
    {
        self::assertSame(
            ['fieldA' => ['$in' => [1, 2]]],
            $this->exprAdapter->in('fieldA', [1, 2])
        );
    }

    public function testNin(): void
    {
        self::assertSame(
            ['fieldA' => ['$nin' => [1, 2]]],
            $this->exprAdapter->notIn('fieldA', [1, 2])
        );
    }

    public function testAnd(): void
    {
        self::assertSame(
            ['$and' => [['expression1'], ['expression2']]],
            $this->exprAdapter->andX([['expression1'], ['expression2']])
        );
    }

    public function testNand(): void
    {
        self::assertSame(
            ['$or' => [['$not' => ['expression1']], ['$not' => ['expression2']]]],
            $this->exprAdapter->nandX([['expression1'], ['expression2']])
        );
    }

    public function testOr(): void
    {
        self::assertSame(
            ['$or' => [['expression1'], ['expression2']]],
            $this->exprAdapter->orX([['expression1'], ['expression2']])
        );
    }

    public function testNor(): void
    {
        self::assertSame(
            ['$nor' => [['expression1'], ['expression2']]],
            $this->exprAdapter->norX([['expression1'], ['expression2']])
        );
    }

    public function testXorX(): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->expectExceptionMessage('Unsupported expression type "xorX".');
        $this->exprAdapter->xorX([]);
    }
}
