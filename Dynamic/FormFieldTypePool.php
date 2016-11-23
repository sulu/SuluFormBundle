<?php

namespace Sulu\Bundle\FormBundle\Dynamic;

class FormFieldTypePool
{
    /**
     * @var FormFieldTypeInterface[]
     */
    private $types;

    public function __construct()
    {
        $this->types = [];
    }

    /**
     * @param FormFieldTypeInterface $type
     * @param string $alias
     */
    public function add(FormFieldTypeInterface $type, $alias)
    {
        $this->types[$alias] = $type;
    }

    /**
     * @param string $alias
     *
     * @return FormFieldTypeInterface
     */
    public function get($alias)
    {
        return $this->types[$alias];
    }

    /**
     * @return FormFieldTypeInterface[]
     */
    public function all()
    {
        return $this->types;
    }
}
