<?php

/*
 * This file is part of Sulu.
 * (c) Sulu GmbH
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
     * @param FormFieldTypeInterface[] $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * Returns type specified by alias.
     */
    public function get(string $alias): FormFieldTypeInterface
    {
        return $this->types[$alias];
    }

    /**
     * Returns all types.
     *
     * @return FormFieldTypeInterface[]
     */
    public function all(): array
    {
        return $this->types;
    }
}
