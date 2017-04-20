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
 * Defines the form type implementation.
 */
interface TitleProviderInterface
{
    /**
     * Returns the title with registered service from given type (e.g. content, event, blog,…).
     *
     * @param string $type
     * @param string $typeId
     */
    public function getTitle($type, $typeId);
}
