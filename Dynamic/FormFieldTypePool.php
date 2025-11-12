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
 */
class FormFieldTypePool
{
    /**
     * @var array<string, FormFieldTypeInterface>
     */
    private $types;

    /**
     * @param iterable<string, FormFieldTypeInterface> $types
     */
    public function __construct(iterable $types)
    {
        $this->types = [...$types];
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
