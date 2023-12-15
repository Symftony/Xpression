<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression\Expr;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Expr\ClosureExpressionBuilder;
use Symftony\Xpression\Lexer;

/**
 * @internal
 *
 * @coversNothing
 */
final class ClosureExpressionBuilderTest extends TestCase
{
    private array $exampleData;

    private ClosureExpressionBuilder $closureExpressionBuilder;

    protected function setUp(): void
    {
        $this->exampleData = [
            'field_null' => null,
            'field_number_5' => 5,
            'field_number_10' => 10,
            'field_string' => 'my_fake_string',
        ];
        $this->closureExpressionBuilder = new ClosureExpressionBuilder();
    }

    public static function provideGetObjectFieldValueCases(): iterable
    {
        yield [
            ['fake_key' => 'fake_value'],
            'fake_key',
            'fake_value',
        ];

        yield [
            new FakeClass(),
            'property1',
            'fake_is_property',
        ];

        yield [
            new FakeClass(),
            'property2',
            'fake_get_property',
        ];

        yield [
            new FakeClass(),
            'callProperty',
            'getcallProperty',
        ];

        yield [
            new FakeClass2(),
            '_property4',
            'property4',
        ];

        yield [
            new FakeArrayAccess(),
            'callProperty',
            'callProperty',
        ];

        $object = new \stdClass();
        $object->property = 'fake_property';
        $object->_property4 = 'fake_property';

        yield [
            $object,
            'property',
            'fake_property',
        ];

        yield [
            $object,
            '_property4',
            'fake_property',
        ];
    }

    /**
     * @dataProvider provideGetObjectFieldValueCases
     */
    public function testGetObjectFieldValue(mixed $object, mixed $value, mixed $expectedResult): void
    {
        self::assertSame($expectedResult, ClosureExpressionBuilder::getObjectFieldValue($object, $value));
    }

    public function testGetSupportedTokenType(): void
    {
        self::assertSame(Lexer::T_ALL, $this->closureExpressionBuilder->getSupportedTokenType());
    }

    public function testParameter(): void
    {
        self::assertSame('my_fake_data', $this->closureExpressionBuilder->parameter('my_fake_data'));
        self::assertSame('my_fake_data', $this->closureExpressionBuilder->parameter('my_fake_data', true));
    }

    public function testString(): void
    {
        self::assertSame('my_fake_data', $this->closureExpressionBuilder->string('my_fake_data'));
    }

    public static function provideIsNullCases(): iterable
    {
        yield ['field_null', true];

        yield ['field_number_5', false];
    }

    /**
     * @dataProvider provideIsNullCases
     */
    public function testIsNull(mixed $field, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->isNull($field);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function provideEqCases(): iterable
    {
        yield ['field_number_5', 1, false];

        yield ['field_number_5', 5, true];

        yield ['field_number_5', 10, false];
    }

    /**
     * @dataProvider provideEqCases
     */
    public function testEq(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->eq($field, $value);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function provideNeqCases(): iterable
    {
        yield ['field_number_5', 1, true];

        yield ['field_number_5', 5, false];

        yield ['field_number_5', 10, true];
    }

    /**
     * @dataProvider provideNeqCases
     */
    public function testNeq(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->neq($field, $value);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function provideGtCases(): iterable
    {
        yield ['field_number_5', 1, true];

        yield ['field_number_5', 5, false];

        yield ['field_number_5', 10, false];
    }

    /**
     * @dataProvider provideGtCases
     */
    public function testGt(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->gt($field, $value);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function provideGteCases(): iterable
    {
        yield ['field_number_5', 1, true];

        yield ['field_number_5', 5, true];

        yield ['field_number_5', 10, false];
    }

    /**
     * @dataProvider provideGteCases
     */
    public function testGte(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->gte($field, $value);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function provideLtCases(): iterable
    {
        yield ['field_number_5', 1, false];

        yield ['field_number_5', 5, false];

        yield ['field_number_5', 10, true];
    }

    /**
     * @dataProvider provideLtCases
     */
    public function testLt(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->lt($field, $value);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function provideLteCases(): iterable
    {
        yield ['field_number_5', 1, false];

        yield ['field_number_5', 5, true];

        yield ['field_number_5', 10, true];
    }

    /**
     * @dataProvider provideLteCases
     */
    public function testLte(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->lte($field, $value);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function inDataProvider(): iterable
    {
        yield ['field_number_5', [1], false];

        yield ['field_number_5', [1, 2, 3, 4, 5], true];
    }

    /**
     * @dataProvider inDataProvider
     */
    public function testIn(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->in($field, $value);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    /**
     * @dataProvider inDataProvider
     */
    public function testNotIn(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->notIn($field, $value);
        self::assertSame(
            !$expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function containsDataProvider(): iterable
    {
        yield ['field_string', 'toto', false];

        yield ['field_string', 'fake', true];
    }

    /**
     * @dataProvider containsDataProvider
     */
    public function testContains(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->contains($field, $value);
        self::assertSame(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    /**
     * @dataProvider containsDataProvider
     */
    public function testNotContains(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->notContains($field, $value);
        self::assertSame(
            !$expectedResult,
            $expression($this->exampleData)
        );
    }

    public static function andXDataProvider(): iterable
    {
        yield [[false, false], false];

        yield [[false, true], false];

        yield [[true, false], false];

        yield [[true, true], true];
    }

    /**
     * @dataProvider andXDataProvider
     */
    public function testAndX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(static fn ($value) => static fn () => $value, $expressions);
        $expression = $this->closureExpressionBuilder->andX($expressionsCallable);
        self::assertSame(
            $expectedResult,
            $expression('useless_data')
        );
    }

    /**
     * @dataProvider andXDataProvider
     */
    public function testNandX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(static fn ($value) => static fn () => $value, $expressions);
        $expression = $this->closureExpressionBuilder->nandX($expressionsCallable);
        self::assertSame(
            !$expectedResult,
            $expression('useless_data')
        );
    }

    public static function orXDataProvider(): iterable
    {
        yield [[false, false], false];

        yield [[false, true], true];

        yield [[true, false], true];

        yield [[true, true], true];
    }

    /**
     * @dataProvider orXDataProvider
     */
    public function testOrX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(static fn ($value) => static fn () => $value, $expressions);
        $expression = $this->closureExpressionBuilder->orX($expressionsCallable);
        self::assertSame(
            $expectedResult,
            $expression('useless_data')
        );
    }

    /**
     * @dataProvider orXDataProvider
     */
    public function testNorX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(static fn ($value) => static fn () => $value, $expressions);
        $expression = $this->closureExpressionBuilder->norX($expressionsCallable);
        self::assertSame(
            !$expectedResult,
            $expression('useless_data')
        );
    }

    public static function provideXorXCases(): iterable
    {
        yield [[false, false], false];

        yield [[false, true], true];

        yield [[true, false], true];

        yield [[true, true], false];

        yield [[false, false, false], false];

        yield [[false, false, true], true];

        yield [[false, true, false], true];

        yield [[false, true, true], false];

        yield [[true, false, false], true];

        yield [[true, false, true], false];

        yield [[true, true, false], false];

        yield [[true, true, true], true];
    }

    /**
     * @dataProvider provideXorXCases
     */
    public function testXorX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(static fn ($value) => static fn () => $value, $expressions);
        $expression = $this->closureExpressionBuilder->xorX($expressionsCallable);
        self::assertEquals(
            $expectedResult,
            $expression('useless_data')
        );
    }
}

class FakeClass
{
    public function __call($name, $arguments)
    {
        return $name.implode(', ', $arguments);
    }

    public function isProperty1()
    {
        return 'fake_is_property';
    }

    public function getProperty2()
    {
        return 'fake_get_property';
    }

    public function isPROPERTY3()
    {
        return 'property3';
    }

    public function getPROPERTY4()
    {
        return 'property4';
    }
}

class FakeClass2
{
    public function isPROPERTY3()
    {
        return 'property3';
    }

    public function getPROPERTY4()
    {
        return 'property4';
    }
}

class FakeArrayAccess implements \ArrayAccess
{
    public function offsetExists($offset): bool
    {
        return false;
    }

    public function offsetGet($offset): mixed
    {
        return $offset;
    }

    public function offsetSet($offset, $value): void {}

    public function offsetUnset($offset): void {}
}
