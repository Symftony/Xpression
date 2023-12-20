<?php

declare(strict_types=1);

namespace Symftony\Xpression;

use Symftony\Xpression\Exception\Lexer\LexerException;
use Symftony\Xpression\Exception\Parser\ForbiddenTokenException;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\Xpression\Exception\Parser\ParserException;
use Symftony\Xpression\Exception\Parser\UnexpectedTokenException;
use Symftony\Xpression\Exception\Parser\UnknownCompositeTypeException;
use Symftony\Xpression\Exception\Parser\UnsupportedTokenTypeException;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;

class Parser
{
    /**
     * @var int Keep the lexer current index
     */
    public int $lexerIndex = 0;

    /**
     * @var array|int[]
     */
    protected array $precedence = [
        Lexer::T_AND => 15,
        Lexer::T_NOT_AND => 14,
        Lexer::T_OR => 10,
        Lexer::T_XOR => 9,
        Lexer::T_NOT_OR => 8,
    ];

    private Lexer $lexer;

    private ExpressionBuilderInterface $expressionBuilder;

    /**
     * @var int Bitwise of all allowed operator. Default was Lexer::T_ALL
     */
    private int $allowedTokenType;

    /**
     * @var int bitwise of ExpressionBuilder supported operator
     */
    private int $supportedTokenType;

    public function __construct(ExpressionBuilderInterface $expressionBuilder)
    {
        $this->lexer = new Lexer();
        $this->expressionBuilder = $expressionBuilder;
    }

    /**
     * @throws InvalidExpressionException
     */
    public function parse(string $input, ?int $allowedTokenType = null): mixed
    {
        $this->allowedTokenType = null !== $allowedTokenType ? $allowedTokenType : Lexer::T_ALL;
        $this->supportedTokenType = $this->expressionBuilder->getSupportedTokenType();

        try {
            $this->lexer->setInput($input);
            $this->lexer->moveNext();

            return $this->getExpression();
        } catch (LexerException $exception) {
            throw new InvalidExpressionException($input, '', 0, $exception);
        } catch (ParserException $exception) {
            throw new InvalidExpressionException($input, '', 0, $exception);
        }
    }

    /**
     * @throws ForbiddenTokenException
     * @throws UnexpectedTokenException
     * @throws UnsupportedTokenTypeException
     */
    private function getExpression(mixed $previousExpression = null): mixed
    {
        $expression = $previousExpression ?: null;
        $expectedTokenType = null !== $previousExpression ? Lexer::T_COMPOSITE : Lexer::T_OPEN_PARENTHESIS | Lexer::T_INPUT_PARAMETER;
        $expressions = [];
        $tokenPrecedence = null;

        $hasOpenParenthesis = false;

        $compositeOperator = null;
        $contains = false;
        $containsValue = null;
        $comparisonFirstOperande = null;
        $comparisonMultipleOperande = false;
        $comparisonMethod = null;

        while ($currentToken = $this->getNextToken()) {
            $currentTokenType = $currentToken['type'];
            $currentTokenIndex = $this->lexerIndex;
            ++$this->lexerIndex;

            if (!($this->supportedTokenType & $currentTokenType)) {
                throw new UnsupportedTokenTypeException($currentToken, $this->lexer->getTokenSyntax($this->supportedTokenType));
            }

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
                        $this->lexerIndex = $currentTokenIndex;
                        $this->lexer->resetPosition($currentTokenIndex);
                        $this->lexer->moveNext();

                        break 2;
                    }
                    $hasOpenParenthesis = false;
                    $expectedTokenType = Lexer::T_COMPOSITE | Lexer::T_CLOSE_PARENTHESIS;

                    break;

                case Lexer::T_COMMA:
                    $expectedTokenType = Lexer::T_OPERAND;

                    break;

                case Lexer::T_INPUT_PARAMETER:
                    $currentTokenValue = $this->expressionBuilder->parameter($currentToken['value'], null !== $comparisonFirstOperande);

                // no break
                case Lexer::T_STRING:
                    if (!isset($currentTokenValue)) {
                        $currentTokenValue = $this->expressionBuilder->string($currentToken['value']);
                    }

                // no break
                case Lexer::T_INTEGER:
                case Lexer::T_FLOAT:
                    if (!isset($currentTokenValue)) {
                        $currentTokenValue = $currentToken['value'];
                    }
                    if (null === $comparisonFirstOperande) {
                        $comparisonFirstOperande = $currentTokenValue;
                        $expectedTokenType = Lexer::T_COMPARISON;
                        $currentTokenValue = null;

                        break;
                    }

                    if (\is_array($comparisonMultipleOperande)) {
                        $comparisonMultipleOperande[] = $currentTokenValue;
                        $expectedTokenType = Lexer::T_COMMA | Lexer::T_CLOSE_SQUARE_BRACKET;
                        $currentTokenValue = null;

                        break;
                    }

                    if ($contains) {
                        $containsValue = $currentTokenValue;
                        $expectedTokenType = Lexer::T_DOUBLE_CLOSE_CURLY_BRACKET;
                        $currentTokenValue = null;

                        break;
                    }
                    $expression = \call_user_func_array([$this->expressionBuilder, $comparisonMethod], [$comparisonFirstOperande, $currentTokenValue]);
                    $comparisonFirstOperande = null;
                    $comparisonMethod = null;
                    $currentTokenValue = null;
                    $expectedTokenType = Lexer::T_COMPOSITE | Lexer::T_CLOSE_PARENTHESIS;

                    break;

                case Lexer::T_EQUALS:
                    $comparisonMethod = 'eq';
                    $expectedTokenType = Lexer::T_OPERAND;

                    break;

                case Lexer::T_NOT_EQUALS:
                    $comparisonMethod = 'neq';
                    $expectedTokenType = Lexer::T_OPERAND;

                    break;

                case Lexer::T_GREATER_THAN:
                    $comparisonMethod = 'gt';
                    $expectedTokenType = Lexer::T_OPERAND;

                    break;

                case Lexer::T_GREATER_THAN_EQUALS:
                    $comparisonMethod = 'gte';
                    $expectedTokenType = Lexer::T_OPERAND;

                    break;

                case Lexer::T_LOWER_THAN:
                    $comparisonMethod = 'lt';
                    $expectedTokenType = Lexer::T_OPERAND;

                    break;

                case Lexer::T_LOWER_THAN_EQUALS:
                    $comparisonMethod = 'lte';
                    $expectedTokenType = Lexer::T_OPERAND;

                    break;

                case Lexer::T_NOT_OPEN_SQUARE_BRACKET:
                    $comparisonMethod = 'notIn';
                    $comparisonMultipleOperande = [];
                    $expectedTokenType = Lexer::T_OPERAND | Lexer::T_CLOSE_SQUARE_BRACKET;

                    break;

                case Lexer::T_OPEN_SQUARE_BRACKET:
                    $comparisonMethod = 'in';
                    $comparisonMultipleOperande = [];
                    $expectedTokenType = Lexer::T_OPERAND | Lexer::T_CLOSE_SQUARE_BRACKET;

                    break;

                case Lexer::T_CLOSE_SQUARE_BRACKET:
                    $expression = \call_user_func_array([$this->expressionBuilder, $comparisonMethod], [$comparisonFirstOperande, $comparisonMultipleOperande]);
                    $comparisonMethod = null;
                    $comparisonFirstOperande = null;
                    $comparisonMultipleOperande = false;
                    $expectedTokenType = Lexer::T_COMPOSITE | Lexer::T_CLOSE_PARENTHESIS;

                    break;

                case Lexer::T_DOUBLE_OPEN_CURLY_BRACKET:
                    $comparisonMethod = 'contains';
                    $contains = true;
                    $expectedTokenType = Lexer::T_OPERAND | Lexer::T_DOUBLE_CLOSE_CURLY_BRACKET;

                    break;

                case Lexer::T_NOT_DOUBLE_OPEN_CURLY_BRACKET:
                    $comparisonMethod = 'notContains';
                    $contains = true;
                    $expectedTokenType = Lexer::T_OPERAND | Lexer::T_DOUBLE_CLOSE_CURLY_BRACKET;

                    break;

                case Lexer::T_DOUBLE_CLOSE_CURLY_BRACKET:
                    $expression = \call_user_func_array([$this->expressionBuilder, $comparisonMethod], [$comparisonFirstOperande, $containsValue]);
                    $comparisonMethod = null;
                    $comparisonFirstOperande = null;
                    $contains = false;
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
                        $expressions = [$this->buildComposite($compositeOperator, $expressions)];
                        $compositeOperator = $currentTokenType;
                        $tokenPrecedence = $currentTokenPrecedence;
                        $expectedTokenType = Lexer::T_OPEN_PARENTHESIS | Lexer::T_INPUT_PARAMETER;

                        break;
                    }

                    if ($currentTokenPrecedence > $tokenPrecedence) {
                        $this->lexerIndex = $currentTokenIndex;
                        $this->lexer->resetPosition($currentTokenIndex);
                        $this->lexer->moveNext();
                        $expression = $this->getExpression($expression);

                        break;
                    }

                    throw new \LogicException(sprintf(
                        'Token precedence error. Current token precedence %s must be different than %s',
                        $currentTokenPrecedence,
                        $tokenPrecedence
                    ));

                default:
                    throw new \LogicException(sprintf(
                        'Token mismatch. Expected token %s given %s',
                        $this->lexer->getLiteral($expectedTokenType),
                        $currentTokenType
                    ));
            }
        }

        if (null !== $expression) {
            $expressions[] = $expression;
        }

        if (1 === \count($expressions)) {
            return $expressions[0];
        }

        return $this->buildComposite($compositeOperator, $expressions);
    }

    /**
     * @param mixed $type
     * @param mixed $expressions
     *
     * @return mixed
     *
     * @throws UnknownCompositeTypeException
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
                throw new UnknownCompositeTypeException($type);
        }
    }

    /**
     * @return null|array
     */
    private function getNextToken(): mixed
    {
        $this->lexer->moveNext();

        return $this->lexer->token;
    }
}
