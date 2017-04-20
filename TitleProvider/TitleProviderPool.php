<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
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

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        return $this->providers[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->providers;
    }
}
