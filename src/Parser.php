<?php

namespace Symftony\Xpression;

use Symftony\Xpression\Exception\Parser\ForbiddenTokenException;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Exception\Parser\UnexpectedTokenException;
use Symftony\Xpression\Exception\Parser\UnknowCompositeTypeException;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;

class Parser
{
    /**
     * @var array
     */
    protected $precedence = array(
        Lexer::T_AND => 15,
        Lexer::T_NOT_AND => 14,
        Lexer::T_OR => 10,
        Lexer::T_XOR => 9,
        Lexer::T_NOT_OR => 8,
    );

    /**
     * @var int Keep the lexer current index
     */
    public $lexerIndex = 0;

    /**
     * @var Lexer
     */
    private $lexer;

    /**
     * @var ExpressionBuilderInterface
     */
    private $expressionBuilder;

    /**
     * @var int Bitwise of all allowed operator. Default was Lexer::T_ALL
     */
    private $allowedTokenType;

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
     * @param null $allowedTokenType
     *
     * @return mixed
     *
     * @throws InvalidExpressionException
     */
    public function parse($input, $allowedTokenType = null)
    {
        if (null !== $allowedTokenType && !is_integer($allowedTokenType)) {
            throw new \InvalidArgumentException('Allowed operator must be an integer.');
        }

        $this->allowedTokenType = $allowedTokenType ?: Lexer::T_ALL;

        try {
            $this->lexer->setInput($input);
            $this->lexer->moveNext();

            return $this->getExpression();
        } catch (\Exception $exception) {
            throw new InvalidExpressionException($input, '', 0, $exception);
        }
    }

    /**
     * @param null $previousExpression
     *
     * @return mixed
     *
     * @throws ForbiddenTokenException
     * @throws UnexpectedTokenException
     */
    private function getExpression($previousExpression = null)
    {
        $expression = $previousExpression ?: null;
        $expectedTokenType = null !== $previousExpression ? Lexer::T_COMPOSITE : Lexer::T_OPEN_PARENTHESIS | Lexer::T_INPUT_PARAMETER;
        $expressions = array();
        $tokenPrecedence = null;

        $hasOpenParenthesis = false;

        $compositeOperator = null;

        $comparisonFirstOperande = null;
        $comparisonMultipleOperande = false;
        $comparisonCallback = null;

        while ($currentToken = $this->getNextToken()) {
            $currentTokenType = $currentToken['type'];
            $currentTokenIndex = $this->lexerIndex;
            $this->lexerIndex++;

            if (!($this->allowedTokenType & $currentTokenType)) {
                throw new ForbiddenTokenException($currentToken, $this->lexer->getTokenSyntax($this->allowedTokenType));
            }

            if (!($expectedTokenType & $currentTokenType)) {
                throw new UnexpectedTokenException($currentToken, $this->lexer->getTokenSyntax($expectedTokenType));
            }

            switch ($currentTokenType) {
                case Lexer::T_OPEN_PARENTHESIS:
                    $expression = $this->getExpression();
                    $hasOpenParenthesis = true;
                    $expectedTokenType = Lexer::T_CLOSE_PARENTHESIS;
                    break;
                case Lexer::T_CLOSE_PARENTHESIS:
                    if (!$hasOpenParenthesis) {
                        $this->lexer->resetPosition($currentTokenIndex);
                        $this->lexer->moveNext();

                        break 2;
                    }
                    $expectedTokenType = Lexer::T_COMPOSITE | Lexer::T_CLOSE_PARENTHESIS;
                    break;
                case Lexer::T_COMMA:
                    $expectedTokenType = Lexer::T_OPERANDE;
                    break;
                case Lexer::T_INPUT_PARAMETER:
                case Lexer::T_INTEGER:
                case Lexer::T_STRING:
                case Lexer::T_FLOAT:
                    if (null === $comparisonFirstOperande) {
                        $comparisonFirstOperande = $currentToken['value'];
                        $expectedTokenType = Lexer::T_COMPARISON | Lexer::T_OPEN_SQUARE_BRACKET | Lexer::T_NOT_OPEN_SQUARE_BRACKET;
                        break;
                    }

                    if (is_array($comparisonMultipleOperande)) {
                        $comparisonMultipleOperande[] = $currentToken['value'];
                        $expectedTokenType = Lexer::T_COMMA | Lexer::T_CLOSE_SQUARE_BRACKET;
                        break;
                    }

                    $expression = call_user_func_array($comparisonCallback, array($comparisonFirstOperande, $currentToken['value']));
                    $comparisonFirstOperande = null;
                    $comparisonCallback = null;
                    $expectedTokenType = Lexer::T_COMPOSITE | Lexer::T_CLOSE_PARENTHESIS;
                    break;
                case Lexer::T_EQUALS:
                    $comparisonCallback = array($this->expressionBuilder, 'eq');
                    $expectedTokenType = Lexer::T_OPERANDE;
                    break;
                case Lexer::T_NOT_EQUALS:
                    $comparisonCallback = array($this->expressionBuilder, 'neq');
                    $expectedTokenType = Lexer::T_OPERANDE;
                    break;
                case Lexer::T_GREATER_THAN:
                    $comparisonCallback = array($this->expressionBuilder, 'gt');
                    $expectedTokenType = Lexer::T_OPERANDE;
                    break;
                case Lexer::T_GREATER_THAN_EQUALS:
                    $comparisonCallback = array($this->expressionBuilder, 'gte');
                    $expectedTokenType = Lexer::T_OPERANDE;
                    break;
                case Lexer::T_LOWER_THAN:
                    $comparisonCallback = array($this->expressionBuilder, 'lt');
                    $expectedTokenType = Lexer::T_OPERANDE;
                    break;
                case Lexer::T_LOWER_THAN_EQUALS:
                    $comparisonCallback = array($this->expressionBuilder, 'lte');
                    $expectedTokenType = Lexer::T_OPERANDE;
                    break;
                case Lexer::T_NOT_OPEN_SQUARE_BRACKET:
                    $comparisonCallback = array($this->expressionBuilder, 'notIn');
                    $comparisonMultipleOperande = array();
                    $expectedTokenType = Lexer::T_OPERANDE | Lexer::T_CLOSE_SQUARE_BRACKET;
                    break;
                case Lexer::T_OPEN_SQUARE_BRACKET:
                    $comparisonCallback = array($this->expressionBuilder, 'in');
                    $comparisonMultipleOperande = array();
                    $expectedTokenType = Lexer::T_OPERANDE | Lexer::T_CLOSE_SQUARE_BRACKET;
                    break;
                case Lexer::T_CLOSE_SQUARE_BRACKET:
                    $expression = call_user_func_array($comparisonCallback, array($comparisonFirstOperande, $comparisonMultipleOperande));
                    $comparisonCallback = null;
                    $comparisonFirstOperande = null;
                    $comparisonMultipleOperande = false;
                    $expectedTokenType = Lexer::T_COMPOSITE | Lexer::T_CLOSE_PARENTHESIS;
                    break;

                case Lexer::T_AND:
                case Lexer::T_NOT_AND:
                case Lexer::T_OR:
                case Lexer::T_NOT_OR:
                case Lexer::T_XOR:
                    $currentTokenPrecedence = $this->precedence[$currentTokenType];
                    if (null === $compositeOperator || $currentTokenType === $compositeOperator) {
                        $expressions[] = $expression;
                        $expression = null;
                        $compositeOperator = $currentTokenType;
                        $tokenPrecedence = $currentTokenPrecedence;
                        $expectedTokenType = Lexer::T_OPEN_PARENTHESIS | Lexer::T_INPUT_PARAMETER;
                        break;
                    }

                    if ($currentTokenPrecedence < $tokenPrecedence) {
                        $expressions[] = $expression;
                        $expression = null;
                        $expressions = array($this->buildComposite($compositeOperator, $expressions));
                        $compositeOperator = $currentTokenType;
                        $tokenPrecedence = $currentTokenPrecedence;
                        $expectedTokenType = Lexer::T_OPEN_PARENTHESIS | Lexer::T_INPUT_PARAMETER;
                        break;
                    }

                    if ($currentTokenPrecedence > $tokenPrecedence) {
                        $this->lexer->resetPosition($currentTokenIndex);
                        $this->lexer->moveNext();
                        $expression = $this->getExpression($expression);
                        break;
                    }
            }
        }

        if (null !== $expression) {
            $expressions[] = $expression;
        }

        if (count($expressions) === 1) {
            return $expressions[0];
        }

        return $this->buildComposite($compositeOperator, $expressions);
    }

    /**
     * @param $type
     * @param $expressions
     *
     * @return mixed
     *
     * @throws UnknowCompositeTypeException
     */
    private function buildComposite($type, $expressions)
    {
        switch ($type) {
            case Lexer::T_AND:
                return $this->expressionBuilder->andX($expressions);
            case Lexer::T_NOT_AND:
                return $this->expressionBuilder->nandX($expressions);
            case Lexer::T_OR:
                return $this->expressionBuilder->orX($expressions);
            case Lexer::T_NOT_OR:
                return $this->expressionBuilder->norX($expressions);
            case Lexer::T_XOR:
                return $this->expressionBuilder->xorX($expressions);
            default:
                throw new UnknowCompositeTypeException($type);
        }
    }

    /**
     * @return array
     */
    private function getNextToken()
    {
        $this->lexer->moveNext();

        return $this->lexer->token;
    }
}
