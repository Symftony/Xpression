<?php

namespace Symftony\Xpression\Exception\Parser;

class InvalidExpressionException extends \RuntimeException
{
    /**
     * @var string
     */
    private $input;

    /**
     * @param string $input
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($input, $message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message !== '' ? $message : 'Invalid expression.', $code, $previous);

        $this->input = $input;
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }
}