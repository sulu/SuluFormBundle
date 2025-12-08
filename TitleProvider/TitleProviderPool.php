<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\TitleProvider;

/**
 * Holds the available Form-Title Provider Types.
 */
class TitleProviderPool implements TitleProviderPoolInterface
{
    /**
     * @var array<string, TitleProviderInterface>
     */
    private $providers;

    /**
     * TitleProviderPool constructor.
     *
     * @param iterable<string, TitleProviderInterface> $providers
     */
    public function __construct(iterable $providers)
    {
        $this->providers = [...$providers];
    }

    public function get(string $alias): TitleProviderInterface
    {
        if (array_key_exists($alias, $this->providers)) {
            return $this->providers[$alias];
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Unknown title provider "%s". Known providers: %s',
                $alias,
                implode(', ',array_keys($this->providers)),
            )
        );
    }

    public function all(): array
    {
        return $this->providers;
    }
}
