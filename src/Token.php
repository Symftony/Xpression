<?php

namespace Symftony\Xpression;

/**
 * Class Token
 *
 * @package Symftony\Xpression
 *
 *  - 'index'    : the index token
 *  - 'value'    : the string value of the token in the input string
 *  - 'type'     : the type of the token (identifier, numeric, string, input, parameter, none)
 *  - 'position' : the position of the token in the input string
 */
class Token
{
    /**
     * @var integer
     */
    private $index;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $position;

    /**
     * @param int $index
     * @param mixed $value
     * @param int $type
     * @param int $position
     */
    public function __construct($index, $value, $type, $position)
    {
        $this->index = (int) $index;
        $this->value = $value;
        $this->type = (int) $type;
        $this->position = (int) $position;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }
}