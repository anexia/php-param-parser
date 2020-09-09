<?php


namespace Anexia\ParamParser\Lexer;


use Anexia\ParamParser\Token\Token;


/**
 * Class ParamOptionsLexer
 *
 * Produces tokens for a param options expression. That is an expression that looks as follows:
 * "text,text,text,text"
 *
 * @package Anexia\ParamParser\Lexer
 */
class ParamOptionsLexer extends AbstractLexer
{

    /**
     * Produces the next token for the input expression.
     *
     * @return Token The next token produced for the expression.
     * @see AbstractLexer::getNextToken()
     */
    public function getNextToken(): Token
    {
        switch ($this->currentCharacter()) {
            case ',':
                return $this->readSingle(Token::TYPE_COMMA);
            case null:
                return $this->readSingle(Token::TYPE_EOF);
            default:
                return $this->readSequence(Token::TYPE_SEQUENCE, [',']);
        }
    }
}
