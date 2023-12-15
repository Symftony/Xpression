<?php

declare(strict_types=1);

namespace Symftony\Xpression\Exception\Parser;

class UnknownCompositeTypeException extends ParserException
{
    public function __construct(
        private mixed $unknownType,
        ?string $message = '',
        int $code = 0,
        \Exception $previous = null,
    ) {
        parent::__construct($message ?: sprintf('Unknown composite type "%s"', $unknownType), $code, $previous);
    }

    public function getUnknownType(): mixed
    {
        return $this->unknownType;
    }
}
