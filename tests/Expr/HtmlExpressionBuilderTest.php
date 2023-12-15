<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression\Expr;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Expr\HtmlExpressionBuilder;
use Symftony\Xpression\Lexer;

/**
 * @internal
 *
 * @coversNothing
 */
final class HtmlExpressionBuilderTest extends TestCase
{
    private HtmlExpressionBuilder $htmlExpressionBuilder;

    protected function setUp(): void
    {
        $this->htmlExpressionBuilder = new HtmlExpressionBuilder();
    }

    public function testGetSupportedTokenType(): void
    {
        self::assertSame(Lexer::T_ALL, $this->htmlExpressionBuilder->getSupportedTokenType());
    }

    public function testParameter(): void
    {
        self::assertSame('my_fake_data', $this->htmlExpressionBuilder->parameter('my_fake_data'));
        self::assertSame('my_fake_data', $this->htmlExpressionBuilder->parameter('my_fake_data', true));
    }

    public function testString(): void
    {
        self::assertSame('"my_fake_data"', $this->htmlExpressionBuilder->string('my_fake_data'));
    }

    public static function provideIsNullCases(): iterable
    {
        yield ['field_null', '<div>field_null is null</div>'];

        yield ['field_number_5', '<div>field_number_5 is null</div>'];
    }

    /**
     * @dataProvider provideIsNullCases
     */
    public function testIsNull(string $field, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->isNull($field)
        );
    }

    public static function provideEqCases(): iterable
    {
        return [
            ['field_number_5', 1, '<div>field_number_5 = 1</div>'],
            ['field_number_5', 5, '<div>field_number_5 = 5</div>'],
            ['field_number_5', 10, '<div>field_number_5 = 10</div>'],
        ];
    }

    /**
     * @dataProvider provideEqCases
     */
    public function testEq(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->eq($field, $value)
        );
    }

    public static function provideNeqCases(): iterable
    {
        yield ['field_number_5', 1, '<div>field_number_5 ≠ 1</div>'];

        yield ['field_number_5', 5, '<div>field_number_5 ≠ 5</div>'];

        yield ['field_number_5', 10, '<div>field_number_5 ≠ 10</div>'];
    }

    /**
     * @dataProvider provideNeqCases
     */
    public function testNeq(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->neq($field, $value)
        );
    }

    public static function provideGtCases(): iterable
    {
        yield ['field_number_5', 1, '<div>field_number_5 > 1</div>'];

        yield ['field_number_5', 5, '<div>field_number_5 > 5</div>'];

        yield ['field_number_5', 10, '<div>field_number_5 > 10</div>'];
    }

    /**
     * @dataProvider provideGtCases
     */
    public function testGt(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->gt($field, $value)
        );
    }

    public static function provideGteCases(): iterable
    {
        yield ['field_number_5', 1, '<div>field_number_5 ≥ 1</div>'];

        yield ['field_number_5', 5, '<div>field_number_5 ≥ 5</div>'];

        yield ['field_number_5', 10, '<div>field_number_5 ≥ 10</div>'];
    }

    /**
     * @dataProvider provideGteCases
     */
    public function testGte(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->gte($field, $value)
        );
    }

    public static function provideLtCases(): iterable
    {
        yield ['field_number_5', 1, '<div>field_number_5 < 1</div>'];

        yield ['field_number_5', 5, '<div>field_number_5 < 5</div>'];

        yield ['field_number_5', 10, '<div>field_number_5 < 10</div>'];
    }

    /**
     * @dataProvider provideLtCases
     */
    public function testLt(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->lt($field, $value)
        );
    }

    public static function provideLteCases(): iterable
    {
        yield ['field_number_5', 1, '<div>field_number_5 ≤ 1</div>'];

        yield ['field_number_5', 5, '<div>field_number_5 ≤ 5</div>'];

        yield ['field_number_5', 10, '<div>field_number_5 ≤ 10</div>'];
    }

    /**
     * @dataProvider provideLteCases
     */
    public function testLte(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->lte($field, $value)
        );
    }

    public static function provideInCases(): iterable
    {
        yield ['field_number_5', [1], '<div>field_number_5 value in 1</div>'];

        yield ['field_number_5', [1, 2, 3, 4, 5], '<div>field_number_5 value in 1, 2, 3, 4, 5</div>'];
    }

    /**
     * @dataProvider provideInCases
     */
    public function testIn(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->in($field, $value)
        );
    }

    public static function provideNotInCases(): iterable
    {
        yield ['field_number_5', [1], '<div>field_number_5 value not in 1</div>'];

        yield ['field_number_5', [1, 2, 3, 4, 5], '<div>field_number_5 value not in 1, 2, 3, 4, 5</div>'];
    }

    /**
     * @dataProvider provideNotInCases
     */
    public function testNotIn(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->notIn($field, $value)
        );
    }

    public static function provideContainsCases(): iterable
    {
        yield ['field_string', 'toto', '<div>field_string contains toto</div>'];

        yield ['field_string', 'fake', '<div>field_string contains fake</div>'];
    }

    /**
     * @dataProvider provideContainsCases
     *
     * @param mixed $field
     * @param mixed $value
     * @param mixed $expectedResult
     */
    public function testContains($field, $value, $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->contains($field, $value)
        );
    }

    public static function provideNotContainsCases(): iterable
    {
        return [
            ['field_string', 'toto', '<div>field_string notContains toto</div>'],
            ['field_string', 'fake', '<div>field_string notContains fake</div>'],
        ];
    }

    /**
     * @dataProvider provideNotContainsCases
     */
    public function testNotContains(string $field, mixed $value, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->notContains($field, $value)
        );
    }

    public static function provideAndXCases(): iterable
    {
        yield [['false', 'false'], '<fieldset><legend>and</legend>falsefalse</fieldset>'];

        yield [['false', 'true'], '<fieldset><legend>and</legend>falsetrue</fieldset>'];

        yield [['true', 'false'], '<fieldset><legend>and</legend>truefalse</fieldset>'];

        yield [['true', 'true'], '<fieldset><legend>and</legend>truetrue</fieldset>'];
    }

    /**
     * @dataProvider provideAndXCases
     */
    public function testAndX(array $expressions, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->andX($expressions)
        );
    }

    public static function provideNandXCases(): iterable
    {
        yield [['false', 'false'], '<fieldset><legend>not-and</legend>falsefalse</fieldset>'];

        yield [['false', 'true'], '<fieldset><legend>not-and</legend>falsetrue</fieldset>'];

        yield [['true', 'false'], '<fieldset><legend>not-and</legend>truefalse</fieldset>'];

        yield [['true', 'true'], '<fieldset><legend>not-and</legend>truetrue</fieldset>'];
    }

    /**
     * @dataProvider provideNandXCases
     */
    public function testNandX(array $expressions, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->nandX($expressions)
        );
    }

    public static function provideOrXCases(): iterable
    {
        yield [['false', 'false'], '<fieldset><legend>or</legend>falsefalse</fieldset>'];

        yield [['false', 'true'], '<fieldset><legend>or</legend>falsetrue</fieldset>'];

        yield [['true', 'false'], '<fieldset><legend>or</legend>truefalse</fieldset>'];

        yield [['true', 'true'], '<fieldset><legend>or</legend>truetrue</fieldset>'];
    }

    /**
     * @dataProvider provideOrXCases
     */
    public function testOrX(array $expressions, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->orX($expressions)
        );
    }

    public static function provideNorXCases(): iterable
    {
        yield [['false', 'false'], '<fieldset><legend>not-or</legend>falsefalse</fieldset>'];

        yield [['false', 'true'], '<fieldset><legend>not-or</legend>falsetrue</fieldset>'];

        yield [['true', 'false'], '<fieldset><legend>not-or</legend>truefalse</fieldset>'];

        yield [['true', 'true'], '<fieldset><legend>not-or</legend>truetrue</fieldset>'];
    }

    /**
     * @dataProvider provideNorXCases
     */
    public function testNorX(array $expressions, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->norX($expressions)
        );
    }

    public static function provideXorXCases(): iterable
    {
        yield [['false', 'false'], '<fieldset><legend>exclusive-or</legend>falsefalse</fieldset>'];

        yield [['false', 'true'], '<fieldset><legend>exclusive-or</legend>falsetrue</fieldset>'];

        yield [['true', 'false'], '<fieldset><legend>exclusive-or</legend>truefalse</fieldset>'];

        yield [['true', 'true'], '<fieldset><legend>exclusive-or</legend>truetrue</fieldset>'];

        yield [['false', 'false', 'false'], '<fieldset><legend>exclusive-or</legend>falsefalsefalse</fieldset>'];

        yield [['false', 'false', 'true'], '<fieldset><legend>exclusive-or</legend>falsefalsetrue</fieldset>'];

        yield [['false', 'true', 'false'], '<fieldset><legend>exclusive-or</legend>falsetruefalse</fieldset>'];

        yield [['false', 'true', 'true'], '<fieldset><legend>exclusive-or</legend>falsetruetrue</fieldset>'];

        yield [['true', 'false', 'false'], '<fieldset><legend>exclusive-or</legend>truefalsefalse</fieldset>'];

        yield [['true', 'false', 'true'], '<fieldset><legend>exclusive-or</legend>truefalsetrue</fieldset>'];

        yield [['true', 'true', 'false'], '<fieldset><legend>exclusive-or</legend>truetruefalse</fieldset>'];

        yield [['true', 'true', 'true'], '<fieldset><legend>exclusive-or</legend>truetruetrue</fieldset>'];
    }

    /**
     * @dataProvider provideXorXCases
     */
    public function testXorX(array $expressions, string $expectedResult): void
    {
        self::assertSame(
            $expectedResult,
            $this->htmlExpressionBuilder->xorX($expressions)
        );
    }
}
