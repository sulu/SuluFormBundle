<?php

/*
 * This file is part of Sulu.
 * (c) Sulu GmbH
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\TitleProvider;

/**
 * Holds the available collection-title types.
 */
interface TitleProviderPoolInterface
{
    /**
     * Returns collection-type specified by alias.
     */
    public function get(string $alias): TitleProviderInterface;

    /**
     * Returns all collection-types.
     *
     * @return TitleProviderInterface[]
     */
    public function all(): array;
}
