<?php

namespace Anexia\ParamParser;

use Anexia\ParamParser\Lexer\ParamSequenceLexer;
use Anexia\ParamParser\Node\ParamNode;
use Anexia\ParamParser\Node\SequenceNode;
use Anexia\ParamParser\Parser\ParamSequenceParser;

/**
 * Parses the given expression and returns an array of {@link SequenceNode} and {@link ParamNode} instances. The
 * expected expression looks as follows:
 * "random-sequence{name:type:option1,option2,option3}other-random-sequence"
 *
 * @param string $expression The expression to parse.
 *
 * @return array
 * @throws Parser\ParserSyntaxException
 */
function parse(string $expression): array
{
    $parser = new ParamSequenceParser(new ParamSequenceLexer($expression), 0);

    return $parser->parse();
}
