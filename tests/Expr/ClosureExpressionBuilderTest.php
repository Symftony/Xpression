<?php

namespace Tests\Symftony\Xpression\Expr;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Expr\ClosureExpressionBuilder;
use Symftony\Xpression\Lexer;

class ClosureExpressionBuilderTest extends TestCase
{
    private array $exampleData;

    private ClosureExpressionBuilder $closureExpressionBuilder;

    public function setUp(): void
    {
        $this->exampleData = [
            'field_null' => null,
            'field_number_5' => 5,
            'field_number_10' => 10,
            'field_string' => 'my_fake_string',
        ];
        $this->closureExpressionBuilder = new ClosureExpressionBuilder();
    }

    public function getObjectFieldValueDataProvider(): array
    {
        $object = new \stdClass();
        $object->property = 'fake_property';
        $object->_property4 = 'fake_property';

        return [
            [
                ['fake_key' => 'fake_value'],
                'fake_key',
                'fake_value',
            ],
            [
                new FakeClass(),
                'property1',
                'fake_is_property',
            ],
            [
                new FakeClass(),
                'property2',
                'fake_get_property',
            ],
            [
                new FakeClass(),
                'callProperty',
                'getcallProperty',
            ],
            [
                new FakeArrayAccess(),
                'callProperty',
                'callProperty',
            ],
            [
                $object,
                'property',
                'fake_property',
            ],
            [
                new FakeClass2(),
                '_property4',
                'property4',
            ],
            [
                $object,
                '_property4',
                'fake_property',
            ],
        ];
    }

    /**
     * @dataProvider getObjectFieldValueDataProvider
     */
    public function testGetObjectFieldValue(mixed $object, mixed $value, mixed $expectedResult): void
    {
        $this->assertEquals($expectedResult, ClosureExpressionBuilder::getObjectFieldValue($object, $value));
    }

    public function testGetSupportedTokenType(): void
    {
        $this->assertEquals(Lexer::T_ALL, $this->closureExpressionBuilder->getSupportedTokenType());
    }

    public function testParameter(): void
    {
        $this->assertEquals('my_fake_data', $this->closureExpressionBuilder->parameter('my_fake_data'));
        $this->assertEquals('my_fake_data', $this->closureExpressionBuilder->parameter('my_fake_data', true));
    }

    public function testString(): void
    {
        $this->assertEquals('my_fake_data', $this->closureExpressionBuilder->string('my_fake_data'));
    }

    public function isNullDataProvider(): array
    {
        return [
            ['field_null', true],
            ['field_number_5', false],
        ];
    }

    /**
     * @dataProvider isNullDataProvider
     */
    public function testIsNull(mixed $field, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->isNull($field);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function eqDataProvider(): array
    {
        return [
            ['field_number_5', 1, false],
            ['field_number_5', 5, true],
            ['field_number_5', 10, false],
        ];
    }

    /**
     * @dataProvider eqDataProvider
     */
    public function testEq(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->eq($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function neqDataProvider(): array
    {
        return [
            ['field_number_5', 1, true],
            ['field_number_5', 5, false],
            ['field_number_5', 10, true],
        ];
    }

    /**
     * @dataProvider neqDataProvider
     */
    public function testNeq(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->neq($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function gtDataProvider(): array
    {
        return [
            ['field_number_5', 1, true],
            ['field_number_5', 5, false],
            ['field_number_5', 10, false],
        ];
    }

    /**
     * @dataProvider gtDataProvider
     */
    public function testGt(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->gt($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function gteDataProvider(): array
    {
        return [
            ['field_number_5', 1, true],
            ['field_number_5', 5, true],
            ['field_number_5', 10, false],
        ];
    }

    /**
     * @dataProvider gteDataProvider
     */
    public function testGte(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->gte($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function ltDataProvider(): array
    {
        return [
            ['field_number_5', 1, false],
            ['field_number_5', 5, false],
            ['field_number_5', 10, true],
        ];
    }

    /**
     * @dataProvider ltDataProvider
     */
    public function testLt(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->lt($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function lteDataProvider(): array
    {
        return [
            ['field_number_5', 1, false],
            ['field_number_5', 5, true],
            ['field_number_5', 10, true],
        ];
    }

    /**
     * @dataProvider lteDataProvider
     */
    public function testLte(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->lte($field, $value);
        $this->assertEquals(
            $expectedResult,
            $expression($this->exampleData)
        );
    }

    public function inDataProvider(): array
    {
        return [
            ['field_number_5', [1], false],
            ['field_number_5', [1, 2, 3, 4, 5], true],
        ];
    }

    /**
     * @dataProvider inDataProvider
     */
    public function testIn(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->in($field, $value);
        $this->assertEquals(
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
        $this->assertEquals(
            !$expectedResult,
            $expression($this->exampleData)
        );
    }

    public function containsDataProvider(): array
    {
        return [
            ['field_string', 'toto', false],
            ['field_string', 'fake', true],
        ];
    }

    /**
     * @dataProvider containsDataProvider
     */
    public function testContains(mixed $field, mixed $value, mixed $expectedResult): void
    {
        $expression = $this->closureExpressionBuilder->contains($field, $value);
        $this->assertEquals(
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
        $this->assertEquals(
            !$expectedResult,
            $expression($this->exampleData)
        );
    }

    public function andXDataProvider(): array
    {
        return [
            [[false, false], false],
            [[false, true], false],
            [[true, false], false],
            [[true, true], true],
        ];
    }

    /**
     * @dataProvider andXDataProvider
     */
    public function testAndX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->andX($expressionsCallable);
        $this->assertEquals(
            $expectedResult,
            $expression('useless_data')
        );
    }

    /**
     * @dataProvider andXDataProvider
     */
    public function testNandX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->nandX($expressionsCallable);
        $this->assertEquals(
            !$expectedResult,
            $expression('useless_data')
        );
    }

    public function orXDataProvider(): array
    {
        return [
            [[false, false], false],
            [[false, true], true],
            [[true, false], true],
            [[true, true], true],
        ];
    }

    /**
     * @dataProvider orXDataProvider
     */
    public function testOrX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->orX($expressionsCallable);
        $this->assertEquals(
            $expectedResult,
            $expression('useless_data')
        );
    }

    /**
     * @dataProvider orXDataProvider
     */
    public function testNorX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->norX($expressionsCallable);
        $this->assertEquals(
            !$expectedResult,
            $expression('useless_data')
        );
    }

    public function xorXDataProvider(): array
    {
        return [
            [[false, false], false],
            [[false, true], true],
            [[true, false], true],
            [[true, true], false],

            [[false, false, false], false],
            [[false, false, true], true],
            [[false, true, false], true],
            [[false, true, true], false],
            [[true, false, false], true],
            [[true, false, true], false],
            [[true, true, false], false],
            [[true, true, true], true],
        ];
    }

    /**
     * @dataProvider xorXDataProvider
     */
    public function testXorX(array $expressions, mixed $expectedResult): void
    {
        $expressionsCallable = array_map(function ($value) {
            return function () use ($value) {
                return $value;
            };
        }, $expressions);
        $expression = $this->closureExpressionBuilder->xorX($expressionsCallable);
        $this->assertEquals(
            $expectedResult,
            $expression('useless_data')
        );
    }
}

class FakeClass
{
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

    public function __call($name, $arguments)
    {
        return $name . implode(', ', $arguments);
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

    public function offsetSet($offset, $value): void
    {
    }

    public function offsetUnset($offset): void
    {
    }
}
