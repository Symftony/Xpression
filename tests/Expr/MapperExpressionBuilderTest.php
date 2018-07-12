<?php

namespace Tests\Symftony\Xpression\Expr;

use PHPUnit\Framework\TestCase;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\Xpression\Expr\MapperExpressionBuilder;

class MapperExpressionBuilderTest extends TestCase
{
    /**
     * @var ExpressionBuilderInterface
     */
    private $expressionBuilderMock;

    /**
     * @var MapperExpressionBuilder
     */
    private $mapperExpressionBuilder;

    public function setUp()
    {
        $this->expressionBuilderMock = $this->prophesize(ExpressionBuilderInterface::class);

        $this->mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal());
    }

    public function testGetSupportedTokenType()
    {
        $this->expressionBuilderMock->getSupportedTokenType()->shouldBeCalled();

        $this->mapperExpressionBuilder->getSupportedTokenType();
    }

    public function testParameter()
    {
        $this->expressionBuilderMock->parameter('fake_field', false)->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $this->mapperExpressionBuilder->parameter('fake_field')
        );
    }

    public function testParameterAsValue()
    {
        $this->expressionBuilderMock->parameter('fake_field', true)->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $this->mapperExpressionBuilder->parameter('fake_field', true)
        );
    }

    public function testString()
    {
        $this->expressionBuilderMock->string('fake_field')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $this->mapperExpressionBuilder->string('fake_field')
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testIsNull($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->isNull($expectedMappedField)->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->isNull($field)
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testEq($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->eq($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->eq($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testNeq($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->neq($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->neq($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testGt($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->gt($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->gt($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testGte($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->gte($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->gte($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testLt($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->lt($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->lt($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testLte($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->lte($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->lte($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testIn($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->in($expectedMappedField, ['fake_value'])->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->in($field, ['fake_value'])
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testNotIn($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->notIn($expectedMappedField, ['fake_value'])->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->notIn($field, ['fake_value'])
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testContains($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->contains($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->contains($field, 'fake_value')
        );
    }

    /**
     * @dataProvider fieldMappingProvider
     *
     * @param $fieldMapping
     * @param $field
     * @param $expectedMappedField
     */
    public function testNotContains($fieldMapping, $field, $expectedMappedField)
    {
        $mapperExpressionBuilder = new MapperExpressionBuilder($this->expressionBuilderMock->reveal(), $fieldMapping);

        $this->expressionBuilderMock->notContains($expectedMappedField, 'fake_value')->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $mapperExpressionBuilder->notContains($field, 'fake_value')
        );
    }

    public function fieldMappingProvider()
    {
        return array(
            array(
                array(),
                'fake_field',
                'fake_field',
            ),
            array(
                array('*' => 'fake_%s_mapping'),
                'fake_field',
                'fake_fake_field_mapping',
            ),
            array(
                array('other' => 'fake_%s_mapping'),
                'fake_field',
                'fake_field',
            ),
            array(
                array('fake_field' => 'fake_%s_mapping'),
                'fake_field',
                'fake_fake_field_mapping',
            ),
        );
    }

    public function testAndX()
    {
        $this->expressionBuilderMock->andX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $this->mapperExpressionBuilder->andX(['fake_expression'])
        );
    }

    public function testNandX()
    {
        $this->expressionBuilderMock->nandX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $this->mapperExpressionBuilder->nandX(['fake_expression'])
        );
    }

    public function testOrX()
    {
        $this->expressionBuilderMock->orX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $this->mapperExpressionBuilder->orX(['fake_expression'])
        );
    }

    public function testNorX()
    {
        $this->expressionBuilderMock->norX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $this->mapperExpressionBuilder->norX(['fake_expression'])
        );
    }

    public function testXorX()
    {
        $this->expressionBuilderMock->xorX(['fake_expression'])->willReturn('fake_return')->shouldBeCalled();

        $this->assertEquals(
            'fake_return',
            $this->mapperExpressionBuilder->xorX(['fake_expression'])
        );
    }
}
