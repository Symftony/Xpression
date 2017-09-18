<?php

namespace Symftony\Xpression;

use Symftony\Xpression\Exception\ExpectedCloseParenthesisException;
use Symftony\Xpression\Exception\ExpectedCompositeOperatorException;
use Symftony\Xpression\Exception\ExpectedOperandeException;
use Symftony\Xpression\Exception\ExpectedSimpleOperatorException;
use Symftony\Xpression\Exception\ParserException;
use Symftony\Xpression\Exception\SyntaxErrorException;
use Symftony\Xpression\Exception\UnexpectedTokenException;

class Parser
{
    protected $precedence = [
        Lexer::T_AND => 15,
//        Lexer::T_NOT_AND => 80,
        Lexer::T_OR => 10,
//        Lexer::T_XOR => 60,
//        Lexer::T_NOT_OR => 50,
    ];
    /**
     * @var ExpressionBuilderInterface
     */
    private $expressionBuilder;

    /**
     * @param ExpressionBuilderInterface $expressionBuilder
     */
    public function __construct(ExpressionBuilderInterface $expressionBuilder)
    {
        $this->lexer = new Lexer();
        $this->expressionBuilder = $expressionBuilder;
    }

    /**
     * @param $input
     *
     * @return mixed
     *
     * @throws ParserException
     */
    public function parse($input)
    {
        try {
            $this->lexer->setInput($input);

            return $this->getExpression2();
            return $this->getExpression();
        } catch (SyntaxErrorException $exception) {
            throw new ParserException($input, 'Parse error.', 0, $exception);
        }
    }

    private function getExpression2($previousSimple = null)
    {

        $expectedTokenType = Lexer::T_OPEN_PARENTHESIS | Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
        $expr = null;
        $simpleExpression = null;
        $combo = [];
        if (null !== $previousSimple) {
            $simpleExpression = $previousSimple;
            $expectedTokenType = Lexer::T_AND | Lexer::T_NOT_AND | Lexer::T_OR | Lexer::T_NOT_OR | Lexer::T_XOR;
        }
        $comboOperator = null;
        $hasOpen = false;

        $firstOperande = null;
        $operator = null;
        $isGroup = false;
        $tokenPrecedence = null;

        while ($this->lexer->moveNext()) {
            $currentToken = $this->lexer->lookahead;
            $currentTokenType = $currentToken->getType();
            $currentTokenIndex = $currentToken->getIndex();
            $currentTokenPrecedence = array_key_exists($currentTokenType, $this->precedence) ? $this->precedence[$currentTokenType] : null;
            if (!($expectedTokenType & $currentTokenType)) {
                throw new UnexpectedTokenException($currentToken, $expectedTokenType);
            }
            switch ($currentTokenType) {
                case Lexer::T_OPEN_PARENTHESIS:
                    $expectedTokenType = Lexer::T_CLOSE_PARENTHESIS;
                    $hasOpen = true;
                    $simpleExpression = $this->getExpression2();
                    var_dump($simpleExpression);die;
                    break;
                case Lexer::T_CLOSE_PARENTHESIS:
                    if (!$hasOpen) {
                        $this->lexer->resetPosition($currentTokenIndex);
                        break 2;
                    }
                    break;
                case Lexer::T_INPUT_PARAMETER:
                case Lexer::T_INTEGER:
                case Lexer::T_STRING:
                case Lexer::T_FLOAT:
                    if (null !== $firstOperande) {
                        $simpleExpression = call_user_func_array($operator, [$firstOperande, $currentToken->getValue()]);
                        $firstOperande = null;
                        $operator = null;
                        $expectedTokenType = Lexer::T_AND | Lexer::T_NOT_AND | Lexer::T_OR | Lexer::T_NOT_OR | Lexer::T_XOR;
                        break;
                    }
                    $firstOperande = $currentToken->getValue();
                    $expectedTokenType = Lexer::T_EQUALS | Lexer::T_NOT_EQUALS | Lexer::T_GREATER_THAN | Lexer::T_GREATER_THAN_EQUALS | Lexer::T_LOWER_THAN | Lexer::T_LOWER_THAN_EQUALS;
                    break;

                case Lexer::T_EQUALS:
                    $operator = [$this->expressionBuilder, 'eq'];
                    $expectedTokenType = Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
                    break;
                case Lexer::T_NOT_EQUALS:
                    $operator = [$this->expressionBuilder, 'neq'];
                    $expectedTokenType = Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
                    break;
                case Lexer::T_GREATER_THAN:
                    $operator = [$this->expressionBuilder, 'gt'];
                    $expectedTokenType = Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
                    break;
                case Lexer::T_GREATER_THAN_EQUALS:
                    $operator = [$this->expressionBuilder, 'gte'];
                    $expectedTokenType = Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
                    break;
                case Lexer::T_LOWER_THAN:
                    $operator = [$this->expressionBuilder, 'lt'];
                    $expectedTokenType = Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
                    break;
                case Lexer::T_LOWER_THAN_EQUALS:
                    $operator = [$this->expressionBuilder, 'lte'];
                    $expectedTokenType = Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
                    break;
//                case Lexer::T_NOT_OPEN_SQUARE_BRACKET:
//                    return $this->expressionBuilder->notIn($firstOperande, $this->getCollectionValues(Lexer::T_CLOSE_SQUARE_BRACKET));
//                case Lexer::T_OPEN_SQUARE_BRACKET:
//                    return $this->expressionBuilder->in($firstOperande, $this->getCollectionValues(Lexer::T_CLOSE_SQUARE_BRACKET));

                case Lexer::T_AND:
                case Lexer::T_NOT_AND:
                case Lexer::T_OR:
                case Lexer::T_NOT_OR:
                case Lexer::T_XOR:
                    if (null === $comboOperator || $currentTokenType === $comboOperator) {
                        $combo[] = $simpleExpression;
                        $simpleExpression = null;
                        $comboOperator = $currentTokenType;
                        $tokenPrecedence = $currentTokenPrecedence;
                        $expectedTokenType = Lexer::T_OPEN_PARENTHESIS | Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
                        break;
                    }


                    if ($currentTokenPrecedence < $tokenPrecedence) {
                        $combo[] = $simpleExpression;
                        $simpleExpression = null;
                        $combo = [$this->buildComposite($comboOperator, $combo)];
                        $comboOperator = $currentTokenType;
                        $tokenPrecedence = $currentTokenPrecedence;
                        $expectedTokenType = Lexer::T_OPEN_PARENTHESIS | Lexer::T_INPUT_PARAMETER | Lexer::T_STRING | Lexer::T_INTEGER | Lexer::T_FLOAT | Lexer::T_INTEGER;
                        break;
                    }


                    if ($currentTokenPrecedence > $tokenPrecedence) {
                        $this->lexer->resetPosition($currentTokenIndex);
                        $simpleExpression = $this->getExpression2($simpleExpression);
                        break;
                    }
            }
        }
//        var_dump($simpleExpression, $combo, $comboOperator);die;
//
//        if (count($combo) === 1) {
//            return $combo[0];
//        }
        if (null !== $simpleExpression) {
            $combo[] = $simpleExpression;
        }

        if (count($combo) === 1) {
            return $combo[0];
        }

//        return call_user_func($comboOperator, $combo);

        return $this->buildComposite($comboOperator, $combo);

        return $expr;
    }

    /**
     * @param $previousToken
     * @param $previousExpr
     *
     * @return mixed
     *
     * @throws ExpectedSimpleOperatorException
     * @throws SyntaxErrorException
     */
    private function getExpressionA()
    {
        $combo = [];
        $token = null;
        $tokenType = null;
        $tokenPrecedence = null;
        $simpleExpression = null;

        while ($this->lexer->moveNext()) {
            $currentToken = $this->lexer->lookahead;
            $currentTokenType = $currentToken['type'];
            $currentTokenIndex = $currentToken['index'];
//            $this->lexer->moveNext();
            $firstoken = $this->lexer->lookahead;
            if (Lexer::T_OPEN_PARENTHESIS === $firstoken['type']) {
                $child = $this->getExpression();

                $this->lexer->moveNext();
                $token = $this->lexer->lookahead;
                if ($token === null) {
                    throw new SyntaxErrorException('Unclosed parenthesis.');
                }
                if ($token['type'] !== Lexer::T_CLOSE_PARENTHESIS) {
                    throw new UnexpectedTokenException($token, ')');
                };
                $combo[] = $child;
            } else {
//                $this->lexer->resetPosition($firstoken['index']);
                var_dump('dcdc');
                die;
                $combo[] = $this->getSimpleExpression();
                continue;
            }

            if ($currentTokenType === Lexer::T_CLOSE_PARENTHESIS) {
                $this->lexer->resetPosition($currentTokenIndex);
                break;
            }
            $currentTokenPrecedence = $this->precedence[$currentTokenType];
            if (!in_array($currentTokenType, [
                Lexer::T_AND,
                Lexer::T_NOT_AND,
                Lexer::T_OR,
                Lexer::T_NOT_OR,
                Lexer::T_XOR,
            ])
            ) {
                throw new ExpectedCompositeOperatorException($currentToken);
            }

            if (null === $token) {
                $token = $currentToken;
                $tokenType = $currentTokenType;
                $tokenPrecedence = $currentTokenPrecedence;
                $simpleExpression = $this->getSimpleExpression();
                continue;
            }

            if ($currentTokenType === $tokenType) {
                $combo[] = $simpleExpression;
                $simpleExpression = $this->getSimpleExpression();
                continue;
            }

            if ($currentTokenPrecedence < $tokenPrecedence) {
                if (null !== $simpleExpression) {
                    $combo[] = $simpleExpression;
                }

                $this->lexer->resetPosition($currentTokenIndex);
                $expression = $this->buildComposite($tokenType, $combo);
                if (null === $previousToken) {
                    return $this->getExpression($token, $expression);
                }

                die('never append');
                return $expression;
            }

            if ($currentTokenPrecedence > $tokenPrecedence) {
                $this->lexer->resetPosition($currentTokenIndex);
                $simpleExpression = $this->getExpression($token, $simpleExpression);
                continue;
            }
        }

        if (null !== $simpleExpression) {
            $combo[] = $simpleExpression;
        }

        if (count($combo) === 1) {
            return $combo[0];
        }

        return $this->buildComposite($tokenType, $combo);
    }


    private function getSimpleExpression()
    {
        $operande = $this->getOperande();

        $this->lexer->moveNext();

        $token = $this->lexer->lookahead;
        switch ($token['type']) {
            case Lexer::T_EQUALS:
                return $this->expressionBuilder->eq($operande, $this->getOperande());
            case Lexer::T_NOT_EQUALS:
                return $this->expressionBuilder->neq($operande, $this->getOperande());
            case Lexer::T_GREATER_THAN:
                return $this->expressionBuilder->gt($operande, $this->getOperande());
            case Lexer::T_GREATER_THAN_EQUALS:
                return $this->expressionBuilder->gte($operande, $this->getOperande());
            case Lexer::T_LOWER_THAN:
                return $this->expressionBuilder->lt($operande, $this->getOperande());
            case Lexer::T_LOWER_THAN_EQUALS:
                return $this->expressionBuilder->lte($operande, $this->getOperande());
            case Lexer::T_NOT_OPEN_SQUARE_BRACKET:
                return $this->expressionBuilder->notIn($operande, $this->getCollectionValues(Lexer::T_CLOSE_SQUARE_BRACKET));
            case Lexer::T_OPEN_SQUARE_BRACKET:
                return $this->expressionBuilder->in($operande, $this->getCollectionValues(Lexer::T_CLOSE_SQUARE_BRACKET));
            default:
                throw new ExpectedSimpleOperatorException($token);
        }
    }

    /**
     * @param $closeTokenType
     * @return array
     * @throws ExpectedOperandeException
     */
    private function getCollectionValues($closeTokenType)
    {
        $values = [$this->getOperande()];
        while ($this->lexer->moveNext()) {
            $inToken = $this->lexer->lookahead;
            if ($inToken['type'] === $closeTokenType) {
                return $values;
            }
            if ($inToken['type'] === Lexer::T_COMMA) {
                $values[] = $this->getOperande();
                continue;
            }
        }

        return $values;
    }

    /**
     * @return mixed
     *
     * @throws ExpectedOperandeException
     */
    private function getOperande()
    {
        while ($this->lexer->moveNext()) {
            $token = $this->lexer->lookahead;
            switch ($token['type']) {
                case Lexer::T_INTEGER:
                case Lexer::T_STRING:
                case Lexer::T_FLOAT:
                case Lexer::T_INPUT_PARAMETER:
                    return $token['value'];
                default:
                    throw new ExpectedOperandeException($token);
            }
        }
    }

    /**
     * @param int $type
     * @param array $combo
     *
     * @return mixed
     *
     * @throws \Exception
     */
    private function buildComposite($type, array $combo)
    {
        switch ($type) {
            case Lexer::T_AND:
                return $this->expressionBuilder->andX($combo);
//            case Lexer::T_NOT_AND:
//                return $this->expressionBuilder->nandX($combo);
            case Lexer::T_OR:
                return $this->expressionBuilder->orX($combo);
            case Lexer::T_NOT_OR:
                return $this->expressionBuilder->norX($combo);
//            case Lexer::T_XOR:
//                return $this->expressionBuilder->xorX($combo);
            default:
                throw new \Exception('composite not allowed');
        }
    }
}
