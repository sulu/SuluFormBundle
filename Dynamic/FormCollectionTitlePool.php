<?php

namespace Sulu\Bundle\FormBundle\Dynamic;

class FormCollectionTitlePool {
    private $types;

    /**
     * FormFieldTypePool constructor.
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
     * @return FormCollectionTitleInterface
     */
    public function get($alias)
    {
        return $this->types[$alias];
    }

    /**
     * Returns all types.
     *
     * @return FormCollectionTitleInterface[]
     */
    public function all()
    {
        return $this->types;
    }
}