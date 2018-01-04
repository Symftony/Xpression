<?php

namespace Symftony\Xpression;

use Doctrine\Common\Lexer\AbstractLexer;
use Symftony\Xpression\Exception\Lexer\UnknownTokenTypeException;

class Lexer extends AbstractLexer
{
    /**
     * @var array
     */
    private $tokenTypes;

    public function __construct($tokenTypes)
    {
//        foreach ($tokenTypes as $tokenType) {
//            if ($tokenType instan) {
//
//            }
//        }

        $this->tokenTypes = $tokenTypes;
    }

    /**
     * @return array
     */
    protected function getCatchablePatterns()
    {
        return array_map(function ($tokenType) {
            return implode('|', $tokenType->getCatchablePatterns());
        }, $this->tokenTypes);
    }

    /**
     * @return array
     */
    protected function getNonCatchablePatterns()
    {
        return array(
            '\s+',
            '(.)',
        );
    }

    /**
     * @param string $value
     *
     * @return int
     *
     * @throws UnknownTokenTypeException
     */
    protected function getType(&$value)
    {
        foreach ($this->tokenTypes as $tokenType) {
            if ($tokenType->supportValue($value)) {
                return get_class($tokenType);
            }
        }

        throw new UnknownTokenTypeException($value);
    }

    public function getLiteral($token)
    {
        foreach ($this->tokenTypes as $tokenType) {
            if (get_class($tokenType) === $token) {
                return $tokenType->getLiteral();
            }
        }

        throw new UnknownTokenTypeException($token);
    }

    /**
     * @param array $tokenTypes
     *
     * @return array
     */
    public function getTokenSyntax(array $tokenTypes)
    {
        $self = $this;
        return array_values(
            array_map(
                function ($tokenType) use ($tokenTypes, $self) {
                    return $self->getLiteral(get_class($tokenType));
                },
                array_filter(
                    $this->tokenTypes,
                    function ($tokenType) use ($tokenTypes) {
                        return in_array(get_class($tokenType), $tokenTypes);
                    }
                )
            )
        );
    }
}
