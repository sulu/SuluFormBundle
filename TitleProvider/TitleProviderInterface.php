<?php

/*
 * This file is part of Sulu.
 * (c) Sulu GmbH
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
     */
    public function getTitle(string $typeId, ?string $locale = null): ?string;
}
