<?php

namespace Symftony\Xpression;

use Symftony\Xpression\Expr\ExpressionBuilderInterface;

class LexerFactory
{
    /**
     * @return \Symftony\Xpression\Lexer
     */
    public static function getLexer()
    {
        return new Lexer(array(
            new Lexer\CommaTokenType(),
            new Lexer\FloatTokenType(),
            new Lexer\IntegerTokenType(),
            new Lexer\StringTokenType(),
            new Lexer\InputParameterTokenType(),
            new Lexer\EqualTokenType(),
            new Lexer\NotEqualTokenType(),
            new Lexer\GreaterThanTokenType(),
            new Lexer\GreaterThanEqualTokenType(),
            new Lexer\LowerThanTokenType(),
            new Lexer\LowerThanEqualTokenType(),
            new Lexer\NotAndTokenType(),
            new Lexer\NotOrTokenType(),
            new Lexer\AndTokenType(),
            new Lexer\OrTokenType(),
            new Lexer\XorTokenType(),
            new Lexer\OpenParenthesisTokenType(),
            new Lexer\CloseParenthesisTokenType(),
            new Lexer\OpenSquareBracketTokenType(),
            new Lexer\NotOpenSquareBracketTokenType(),
            new Lexer\CloseSquareBracketTokenType(),
            new Lexer\DoubleOpenCurlyBracketTokenType(),
            new Lexer\NotDoubleOpenCurlyBracketTokenType(),
            new Lexer\DoubleCloseCurlyBracketTokenType(),
        ));
    }

    public function create(ExpressionBuilderInterface $expressionBuilder)
    {
        return self::getLexer();
    }
}
