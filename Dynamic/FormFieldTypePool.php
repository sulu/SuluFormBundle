<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic;

/**
 * Holds the available form types.
 *
 * @param iterable<string, FormFieldTypeInterface> $types
 */
class FormFieldTypePool
{
    /**
     * @var array<string, FormFieldTypeInterface>
     */
    private array $types;

    /**
     * @param iterable<string, FormFieldTypeInterface> $types
     */
    public function __construct(iterable $types)
    {
        $this->types = $types instanceof \Traversable ? \iterator_to_array($types) : $types;
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
     * @return array<string, FormFieldTypeInterface>
     */
    public function all(): array
    {
        return $this->types;
    }
}
