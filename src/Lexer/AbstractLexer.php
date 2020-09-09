<?php


namespace Anexia\ParamParser\Lexer;


use Anexia\ParamParser\Token\Token;


/**
 * Class AbstractLexer
 *
 * Base class for all lexer implementations, such as a {@link ParamLexer}. A lexer takes an input
 * expression and produces tokens of it. Those tokens are consumed by a parser implementation.
 *
 * @package Anexia\ParamParser\Lexer
 */
abstract class AbstractLexer
{

    /**
     * Member variable that holds the expression the lexer should produce tokens
     * from.
     *
     * @var string
     */
    protected $expression = null;

    /**
     * Member variable that holds the current position to get the next token
     * from.
     *
     * @var int
     */
    protected $position = null;

    /**
     * AbstractLexer constructor.
     *
     * @param string $expression The expression the lexer should produce tokens for.
     */
    public function __construct(string $expression)
    {
        $this->expression = $expression;
        $this->position   = 0;
    }

    /**
     * Produces the next token for the expression and advances the position pointer
     * accordingly. This method should produce a {@link Token} instance of type {@link Token::TYPE_EOF}
     * if the end of the expression is reached. Subsequent calls to this method also produce an EOF token.
     *
     * @return Token The next token produced for the expression.
     */
    abstract public function getNextToken(): Token;

    /**
     * Reads the next character on the expression and produces a {@link Token} of the given type
     * from it. Advances the position pointer by one.
     *
     * @param string $tokenType Type of the token to produce
     *
     * @return Token Produced token instance
     */
    protected function readSingle(string $tokenType): Token
    {
        $token = new Token($this->position, $tokenType, $this->currentCharacter(), $this->currentCharacter());
        $this->advance();

        return $token;
    }

    /**
     * Gets the current character the position pointer points to on the expression. If the position
     * pointer exceeds the length of the expression, NULL gets returned.
     *
     * @return string|null
     */
    protected function currentCharacter(): ?string
    {
        if ($this->position >= strlen($this->expression)) {
            return null;
        }

        return $this->expression[$this->position];
    }

    /**
     * Advances the position pointer by one. This method gets called by the {@link AbstractLexer::readSingle()}
     * and {@link AbstractLexer::readSequence()} methods.
     */
    protected function advance()
    {
        $this->position++;
    }

    /**
     * Reads a sequence of characters on the expression and produces a {@link Token} of the given
     * type from it. Reads until one of the given until-characters gets read as the current character or
     * until the end of the expression is reached. The position pointer points to the character that ended
     * the sequence after calling this method.
     *
     * @param string $tokenType Type of the token to produce
     * @param array  $until     Array of characters that end the sequence
     *
     * @return Token Produced token instance
     */
    protected function readSequence(string $tokenType, array $until): Token
    {
        $sequence    = '';
        $rawSequence = '';
        $until       = array_merge([null,], $until);
        $position    = $this->position;

        while (!in_array($this->currentCharacter(), $until)) {
            if ($this->currentCharacter() === '\\') {
                $rawSequence .= $this->currentCharacter();
                $this->advance();
            }

            if ($this->currentCharacter() !== null) {
                $sequence    .= $this->currentCharacter();
                $rawSequence .= $this->currentCharacter();
                $this->advance();
            }
        }

        return new Token($position, $tokenType, $sequence, $rawSequence);
    }

}
