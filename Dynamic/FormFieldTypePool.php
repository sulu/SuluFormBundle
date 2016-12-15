<?php

namespace Sulu\Bundle\FormBundle\Dynamic;

/**
 * Holds the available form types.
 */
class FormFieldTypePool
{
    /**
     * @var FormFieldTypeInterface[]
     */
    private $types;

    /**
     * FormFieldTypePool constructor.
     *
     * @param FormFieldTypeInterface[] $types
     */
    public function __construct($types)
    {
        $this->types = $types;
    }

    /**
     * Returns type specified by alias.
     *
     * @param string $alias
     *
     * @return FormFieldTypeInterface
     */
    public function get($alias)
    {
        return $this->types[$alias];
    }

    /**
     * Returns all types.
     *
     * @return FormFieldTypeInterface[]
     */
    public function all()
    {
        return $this->types;
    }
}
