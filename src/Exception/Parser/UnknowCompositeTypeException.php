<?php

namespace Symftony\Xpression\Exception\Parser;

class UnknowCompositeTypeException extends ParserException
{
    /**
     * @var string
     */
    private $unknownType;

    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($unknownType, $message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message ?: sprintf('Unknown composite type "%s"', $unknownType), $code, $previous);

        $this->unknownType = $unknownType;
    }

    /**
     * @return string
     */
    public function getUnknownType()
    {
        return $this->unknownType;
    }
}