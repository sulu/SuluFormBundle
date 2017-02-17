<?php
/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic;

/**
 * Holds the available collection-title types.
 */
interface CollectionTitleProviderPoolInterface
{
    /**
     * Returns collection-type specified by alias.
     *
     * @param string $alias
     *
     * @return CollectionTitleProviderInterface
     */
    public function get($alias);

    /**
     * Returns all collection-types.
     *
     * @return CollectionTitleProviderInterface[]
     */
    public function all();
}
