<?php


namespace Anexia\ParamParser\Node;


/**
 * Class ParamNode
 *
 * A param node represents a section in the input expression that defines a param with all its
 * meta data. A param always has a name, might have a type and has a list of options.
 *
 * @package Anexia\ParamParser\Node
 */
class ParamNode extends AbstractNode
{

    /**
     * Member variable that holds the name of the param.
     *
     * @var string
     */
    protected $paramName = null;

    /**
     * Member variable that holds the optional type of the param.
     *
     * @var string|null
     */
    protected $paramType = null;

    /**
     * Member variable that holds the list of options of the param. Each option
     * is a string.
     *
     * @var array<string>
     */
    protected $paramOptions = null;

    /**
     * ParamNode constructor.
     *
     * @param string      $paramName    The name of the param.
     * @param string|null $paramType    The optional type of the param.
     * @param array|null  $paramOptions The list of options of the param. Becomes an empty list if NULL was given.
     */
    public function __construct(string $paramName, ?string $paramType, ?array $paramOptions)
    {
        $this->paramName    = $paramName;
        $this->paramType    = $paramType ? $paramType : null;
        $this->paramOptions = $paramOptions ? $paramOptions : [];
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'ParamNode(%s, %s, %s)',
            var_export($this->paramName, true),
            var_export($this->paramType, true),
            var_export($this->paramOptions, true)
        );
    }

    /**
     * Gets the name of the param.
     *
     * @return string|null
     */
    public function getParamName(): string
    {
        return $this->paramName;
    }

    /**
     * Gets the type of the param. Returns NULL if no type was defined.
     *
     * @return string|null
     */
    public function getParamType(): ?string
    {
        return $this->paramType;
    }

    /**
     * Returns the list of options of the param. Each option is represented as
     * a string. An empty list is returned if no options were given.
     *
     * @return array|null
     */
    public function getParamOptions(): array
    {
        return $this->paramOptions;
    }
}
