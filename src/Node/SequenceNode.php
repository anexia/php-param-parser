<?php

namespace Anexia\ParamParser\Node;

/**
 * Class SequenceNode
 *
 * A sequence node represents a section in the input expression that is a plain text sequence.
 *
 * @package Anexia\ParamParser\Node
 */
class SequenceNode extends AbstractNode
{
    /**
     * Member variable that holds the value of the sequence.
     *
     * @var string
     */
    protected $sequenceValue = null;

    /**
     * SequenceNode constructor.
     *
     * @param string $sequenceValue The value of the sequence.
     */
    public function __construct(string $sequenceValue)
    {
        $this->sequenceValue = $sequenceValue;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        // @codeCoverageIgnoreStart
        return sprintf(
            'SequenceNode(%s)',
            var_export($this->sequenceValue, true)
        );
        // @codeCoverageIgnoreEnd
    }

    /**
     * Gets the value of the sequence.
     *
     * @return string
     */
    public function getSequenceValue(): string
    {
        return $this->sequenceValue;
    }
}
