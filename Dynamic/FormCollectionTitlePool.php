<?php
namespace Sulu\Bundle\FormBundle\Dynamic;

/**
 * Holds the available Form-Collections Types.
 */
class FormCollectionTitlePool {
    private $types;

    /**
     * FormCollectionTitlePool constructor.
     */
    public function __construct($types)
    {
        $this->types = $types;
    }

    /**
     * Returns collection-type specified by alias.
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
     * Returns all collection-types.
     *
     * @return FormCollectionTitleInterface[]
     */
    public function all()
    {
        return $this->types;
    }
}