<?php

namespace Symftony\Xpression;

use Doctrine\Common\Lexer\AbstractLexer;
use Symftony\Xpression\Exception\Lexer\InvalidArgumentException;
use Symftony\Xpression\Exception\Lexer\UnknownTokenTypeException;
use Symftony\Xpression\Lexer\TokenTypeInterface;

class Lexer extends AbstractLexer
{
    /**
     * @var array
     */
    private $tokenTypes;

    /**
     * @var array
     */
    private $nonCatchablePatterns;

    /**
     * @param $tokenTypes
     * @param $nonCatchablePatterns
     */
    public function __construct(array $tokenTypes, array $nonCatchablePatterns = null)
    {
        $this->tokenTypes = array();

        foreach ($tokenTypes as $tokenType) {
            if (!($tokenType instanceof TokenTypeInterface)) {
                throw new InvalidArgumentException('Token type must implement TokenTypeInterface.');
            }
            $this->tokenTypes[get_class($tokenType)] = $tokenType;
        }

        $this->nonCatchablePatterns = $nonCatchablePatterns ?: array('\s+', '(.)',);
    }

    /**
     * @return array
     */
    public function getTokenTypes()
    {
        return $this->tokenTypes;
    }

    /**
     * @return array
     */
    protected function getCatchablePatterns()
    {
        return array_map(function (TokenTypeInterface $tokenType) {
            return implode('|', $tokenType->getCatchablePatterns());
        }, $this->tokenTypes);
    }

    /**
     * @return array
     */
    protected function getNonCatchablePatterns()
    {
        return $this->nonCatchablePatterns;
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

    /**
     * @param int $token
     *
     * @return mixed
     *
     * @throws UnknownTokenTypeException
     */
    public function getLiteral($token)
    {
        if (!array_key_exists($token, $this->tokenTypes)) {
            throw new UnknownTokenTypeException($token);
        }

        return $this->tokenTypes[$token]->getLiteral();
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
