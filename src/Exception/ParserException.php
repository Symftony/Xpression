<?php

namespace Symftony\Xpression\Exception;

class ParserException extends \Exception
{
    /**
     * @var string
     */
    private $input;

    /**
     * @param string $input
     * @param int $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($input, $message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

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