<?php

namespace Tests\Symftony\Xpression\Bridge\MongoDB;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Bridge\MongoDB\ExprBuilder;
use Symftony\Xpression\Exception\Expr\UnsupportedExpressionTypeException;
use Symftony\Xpression\Lexer;

class ExprBuilderTest extends TestCase
{
    private ExprBuilder $exprAdapter;

    public function setUp(): void
    {
        $this->exprAdapter = new ExprBuilder();
    }

    public function testGetSupportedTokenType(): void
    {
        $this->assertEquals(Lexer::T_ALL - Lexer::T_XOR, $this->exprAdapter->getSupportedTokenType());
    }

    public function testIsNull(): void
    {
        $field = 'fake_field';
        $this->assertEquals(['fake_field' => null], $this->exprAdapter->isNull($field));
    }

    public function testEq(): void
    {
        $this->assertEquals(
            ['fieldA' => ['$eq' => 1]],
            $this->exprAdapter->eq('fieldA', 1)
        );
    }

    public function testNeq(): void
    {
        $this->assertEquals(
            ['fieldA' => ['$ne' => 1]],
            $this->exprAdapter->neq('fieldA', 1)
        );
    }

    public function testGt(): void
    {
        $this->assertEquals(
            ['fieldA' => ['$gt' => 1]],
            $this->exprAdapter->gt('fieldA', 1)
        );
    }

    public function testGte(): void
    {
        $this->assertEquals(
            ['fieldA' => ['$gte' => 1]],
            $this->exprAdapter->gte('fieldA', 1)
        );
    }

    public function testLt(): void
    {
        $this->assertEquals(
            ['fieldA' => ['$lt' => 1]],
            $this->exprAdapter->lt('fieldA', 1)
        );
    }

    public function testLte(): void
    {
        $this->assertEquals(
            ['fieldA' => ['$lte' => 1]],
            $this->exprAdapter->lte('fieldA', 1)
        );
    }

    public function testIn(): void
    {
        $this->assertEquals(
            ['fieldA' => ['$in' => [1, 2]]],
            $this->exprAdapter->in('fieldA', [1, 2])
        );
    }

    public function testNin(): void
    {
        $this->assertEquals(
            ['fieldA' => ['$nin' => [1, 2]]],
            $this->exprAdapter->notIn('fieldA', [1, 2])
        );
    }

    public function testAnd(): void
    {
        $this->assertEquals(
            ['$and' => [['expression1'], ['expression2']]],
            $this->exprAdapter->andX([['expression1'], ['expression2']])
        );
    }

    public function testNand(): void
    {
        $this->assertEquals(
            ['$or' => [['$not' => ['expression1']], ['$not' => ['expression2']]]],
            $this->exprAdapter->nandX([['expression1'], ['expression2']])
        );
    }

    public function testOr(): void
    {
        $this->assertEquals(
            ['$or' => [['expression1'], ['expression2']]],
            $this->exprAdapter->orX([['expression1'], ['expression2']])
        );
    }

    public function testNor(): void
    {
        $this->assertEquals(
            ['$nor' => [['expression1'], ['expression2']]],
            $this->exprAdapter->norX([['expression1'], ['expression2']])
        );
    }

    public function testXorX(): void
    {
        $this->expectException(UnsupportedExpressionTypeException::class);
        $this->exprAdapter->xorX([]);
    }
}
