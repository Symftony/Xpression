<?php

declare(strict_types=1);

namespace Tests\Symftony\Xpression\Expr;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Expr\MapperExpressionBuilder;

/**
 * @covers \Symftony\Xpression\Expr\MapperExpressionBuilder
 */
final class MapperExpressionBuilderTest extends TestCase
{
    private ExpressionBuilderInterface|ObjectProphecy $expressionBuilderMock;

    private MapperExpressionBuilder $mapperExpressionBuilder;

    private Prophet $prophet;

    protected function setUp(): void
    {
        $this->prophet = new Prophet();
        $this->expressionBuilderMock = $this->prophet->prophesize(ExpressionBuilderInterface::class);
        $this->mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal());
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }

    public function testGetSupportedTokenType(): void
    {
        $this->expectNotToPerformAssertions();
        $this->expressionBuilderMock->getSupportedTokenType()->shouldBeCalled();

        $this->mapperExpressionBuilder->getSupportedTokenType();
    }

    public function testParameter(): void
    {
        $this->expressionBuilderMock->parameter('fake_field', false)->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $this->mapperExpressionBuilder->parameter('fake_field')
        );
    }

    public function testParameterAsValue(): void
    {
        $this->expressionBuilderMock->parameter('fake_field', true)->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $this->mapperExpressionBuilder->parameter('fake_field', true)
        );
    }

    public function testString(): void
    {
        $this->expressionBuilderMock->string('fake_field')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $this->mapperExpressionBuilder->string('fake_field')
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testIsNull(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->isNull($expectedMappedField)->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->isNull($field)
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testEq(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->eq($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->eq($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testNeq(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->neq($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->neq($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testGt(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->gt($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->gt($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testGte(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->gte($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->gte($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testLt(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->lt($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->lt($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testLte(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->lte($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->lte($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testIn(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->in($expectedMappedField, ['fake_value'])->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->in($field, ['fake_value'])
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testNotIn(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->notIn($expectedMappedField, ['fake_value'])->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->notIn($field, ['fake_value'])
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testContains(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->contains($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->contains($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingDataProvider
     */
    public function testNotContains(array $fieldMapping, mixed $field, mixed $expectedMappedField): void
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->notContains($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $mapperExpressionBuilder->notContains($field, 'fake_value')
        );
    }

    public static function fieldMappingDataProvider(): iterable
    {
        yield [
            [],
            'fake_field',
            'fake_field',
        ];

        yield [
            ['*' => 'fake_%s_mapping'],
            'fake_field',
            'fake_fake_field_mapping',
        ];

        yield [
            ['other' => 'fake_%s_mapping'],
            'fake_field',
            'fake_field',
        ];

        yield [
            ['fake_field' => 'fake_%s_mapping'],
            'fake_field',
            'fake_fake_field_mapping',
        ];
    }

    public function testAndX(): void
    {
        $this->expressionBuilderMock->andX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $this->mapperExpressionBuilder->andX(['fake_expression'])
        );
    }

    public function testNandX(): void
    {
        $this->expressionBuilderMock->nandX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $this->mapperExpressionBuilder->nandX(['fake_expression'])
        );
    }

    public function testOrX(): void
    {
        $this->expressionBuilderMock->orX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $this->mapperExpressionBuilder->orX(['fake_expression'])
        );
    }

    public function testNorX(): void
    {
        $this->expressionBuilderMock->norX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $this->mapperExpressionBuilder->norX(['fake_expression'])
        );
    }

    public function testXorX(): void
    {
        $this->expressionBuilderMock->xorX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        self::assertSame(
            'fake_return',
            $this->mapperExpressionBuilder->xorX(['fake_expression'])
        );
    }
}
