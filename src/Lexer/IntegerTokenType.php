<?php

namespace Symftony\Xpression\Lexer;

class IntegerTokenType extends AbstractTokenType
{
    const
        ALLOW_ALL = 15,
        ALLOW_DECIMAL = 0,
        ALLOW_NEGATIVE = 1,
        ALLOW_BINARY = 2,
        ALLOW_HEXADECIMAL = 4,
        ALLOW_OCTAL = 8;

    /**
     * @var string
     */
    private $catchablePatterns;

    /**
     * @var string
     */
    private $supportedPatterns;

    /**
     * @var string
     */
    private $literal;

    /**
     * @param int $allowedFormat
     */
    public function __construct($allowedFormat = self::ALLOW_ALL)
    {
        $allowedFormats = array();
        $supportFormats = array();
        $literalFormats = array('1');

        if ($allowedFormat & self::ALLOW_BINARY) {
            $allowedFormats[] = '0b[01]+';
            $supportFormats[] = '0b[01]+';
            $literalFormats[] = '0b101';
        }
        if ($allowedFormat & self::ALLOW_HEXADECIMAL) {
            $allowedFormats[] = '0[xX][0-9a-fA-F]+';
            $supportFormats[] = '0[xX][0-9a-fA-F]+';
            $literalFormats[] = '0x1A';
        }
        if ($allowedFormat & self::ALLOW_OCTAL) {
            $allowedFormats[] = '0[0-7]+';
            $literalFormats[] = '03';
        }

        $allowedFormats[] = '[1-9][0-9]*|0';
        $this->catchablePatterns = sprintf('(?:%s)', implode('|', $allowedFormats));
        $this->supportedPatterns = sprintf('(?:%s)', implode('|', $supportFormats));
        $this->literal = sprintf('integer (%s)', implode(' / ', $literalFormats));
        if ($allowedFormat & self::ALLOW_NEGATIVE) {
            $this->catchablePatterns = sprintf('(?:[+-]?%s)', $this->catchablePatterns);
            $this->supportedPatterns = sprintf('(?:[+-]?%s)', $this->supportedPatterns);
            $this->literal = sprintf('signed %s', $this->literal);
        }
    }

    public function getLiteral()
    {
        return $this->literal;
    }

    public function getCatchablePatterns()
    {
        return array($this->catchablePatterns);
    }

    public function supportValue(&$value)
    {
        if (is_numeric($value) || preg_match('/' . $this->supportedPatterns . '/', $value)) {
            if (PHP_VERSION_ID < 70200 && preg_match('/(?<sign>[+-]?)0b(?<number>[01]+)/', $value, $result)) {
                $value = intval($result['sign'] . $result['number'], 2);

                return true;
            }
            $value = intval($value, 0);

            return true;
        }

        return false;
    }
}
