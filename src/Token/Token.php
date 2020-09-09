<?php


namespace Anexia\ParamParser\Token;


/**
 * Class Token
 *
 * A token represents a sequence of characters that build up the structure of an expression. Tokens are
 * produced by a lexer.
 *
 * @package Anexia\ParamParser\Token
 */
class Token
{
    public const TYPE_EOF        = 'EOF';
    public const TYPE_SEQUENCE   = 'SEQUENCE';
    public const TYPE_LC_BRACKET = 'LC_BRACKET';
    public const TYPE_RC_BRACKET = 'RC_BRACKET';
    public const TYPE_COLON      = 'COLON';
    public const TYPE_COMMA      = 'COMMA';

    /**
     * Member variable that holds the position of the token within the expression.
     *
     * @var int
     */
    protected $tokenPosition = null;

    /**
     * Member variable that holds the type of the token, such as "LC_BRACKET" or "COMMA".
     *
     * @var string
     */
    protected $tokenType = null;

    /**
     * Member variable that holds the value of the token. This value does not contain escape characters.
     *
     * @var string|null
     */
    protected $tokenValue = null;

    /**
     * Member variable that holds the raw value of the token. This value does contain escape characters.
     *
     * @var string|null
     */
    protected $tokenRawValue = null;

    /**
     * Token constructor.
     *
     * @param int         $tokenPosition Position of the token.
     * @param string      $tokenType     Type of the token, such as "LC_BRACKET" or "COMMA".
     * @param string|null $tokenValue    Value of the token without escape characters.
     * @param string|null $tokenRawValue Raw value of the token with escape characters.
     */
    public function __construct(int $tokenPosition, string $tokenType, ?string $tokenValue, ?string $tokenRawValue)
    {
        $this->tokenPosition = $tokenPosition;
        $this->tokenType     = $tokenType;
        $this->tokenValue    = $tokenValue;
        $this->tokenRawValue = $tokenRawValue;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'Token(%s, %s, %s, %s)',
            var_export($this->tokenPosition, true),
            var_export($this->tokenType, true),
            var_export($this->tokenValue, true),
            var_export($this->tokenRawValue, true)
        );
    }

    /**
     * Gets the position of the token within the expression.
     *
     * @return int
     */
    public function getTokenPosition(): int
    {
        return $this->tokenPosition;
    }

    /**
     * Gets the type of the token, such as "LC_BRACKET" or "COMMA".
     *
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * Gets the value of the token without the escape characters. "EOF" tokens
     * have a NULL value.
     *
     * @return string|null
     */
    public function getTokenValue(): ?string
    {
        return $this->tokenValue;
    }

    /**
     * Gets the raw value of the token with the escape characters. "EOF" tokens
     * have a NULL value.
     *
     * @return string|null
     */
    public function getTokenRawValue(): ?string
    {
        return $this->tokenRawValue;
    }
}
