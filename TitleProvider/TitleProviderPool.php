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
     * @var TitleProviderInterface[]
     */
    private $providers;

    /**
     * TitleProviderPool constructor.
     *
     * @param TitleProviderInterface[] $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function get(string $alias): TitleProviderInterface
    {
        return $this->providers[$alias];
    }

    public function all(): array
    {
        return $this->providers;
    }
}
