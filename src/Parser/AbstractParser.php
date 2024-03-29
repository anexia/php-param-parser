<?php

namespace Anexia\ParamParser\Parser;

use Anexia\ParamParser\Lexer\AbstractLexer;
use Anexia\ParamParser\Token\Token;

/**
 * Class AbstractParser
 *
 * Base class for all parser implementations, such as a {@link ParamSequenceParser}. A parser takes the
 * stream of tokens produced by the lexer and returns a meaningful representation of the data.
 *
 * @package Anexia\ParamParser\Parser
 */
abstract class AbstractParser
{
    /**
     * Member variable that holds the lexer that produces the tokens for the parser.
     *
     * @var AbstractLexer
     */
    protected $lexer = null;

    /**
     * Member variable that holds the absolute offset for the produced tokens. This is
     * useful for parsers that process a subsection of the total expression. Parsing
     * exceptions will contain the absolute position of the failure calculated by the
     * offset.
     *
     * @var int
     */
    protected $offset = null;

    /**
     * AbstractParser constructor.
     *
     * @param AbstractLexer $lexer  Lexer that produces the tokens for the parser.
     * @param int           $offset Offset to calculate absolute token position.
     */
    public function __construct(AbstractLexer $lexer, int $offset)
    {
        $this->lexer  = $lexer;
        $this->offset = $offset;
    }

    /**
     * Parses the stream of tokens generated by the lexer and returns a meaningful
     * representation of the data as array. Depending on the type of parser, this array might
     * contain a list of strings or might contain a list of nodes.
     *
     * @return array
     */
    abstract public function parse(): array;

    /**
     * Consumes the next token produced by the lexer. If a list of valid token types is given
     * as an array, this method will throw a {@link ParserSyntaxException} if the produced
     * token's type is not within the list.
     *
     * @param array|null $tokenTypes Array of valid token types.
     *
     * @return Token
     * @throws ParserSyntaxException
     */
    public function eat(?array $tokenTypes)
    {
        $token = $this->lexer->getNextToken();

        if ($tokenTypes && !in_array($token->getTokenType(), $tokenTypes)) {
            $this->throwUnexpectedToken($token);
        }

        return $token;
    }

    /**
     * Throws a {@link ParserSyntaxException} for the given token.
     *
     * @param Token $token Token to throw an exception for.
     *
     * @throws ParserSyntaxException
     */
    protected function throwUnexpectedToken(Token $token)
    {
        throw new ParserSyntaxException(
            sprintf(
                'Unexpected token \'%s\' at position \'%d\'',
                $token->getTokenType(),
                $token->getTokenPosition() + $this->offset
            )
        );
    }
}
