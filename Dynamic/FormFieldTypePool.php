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
final class FormFieldTypePool
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

    public function get(string $type): FormFieldTypeInterface
    {
        if (\array_key_exists($type, $this->types)) {
            return $this->types[$type];
        }

        throw new \InvalidArgumentException(
            \sprintf(
                'Unknown title provider "%s". Known providers: %s',
                $type,
                \implode(', ', \array_keys($this->types)),
            )
        );
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
