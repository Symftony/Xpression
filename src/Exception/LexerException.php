<?php

namespace Symftony\Xpression\Exception;

class LexerException extends \Exception
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($value, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('Unexpected token "%s".', $value), $code, $previous);

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}