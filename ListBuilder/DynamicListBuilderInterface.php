<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\ListBuilder;

use Sulu\Bundle\FormBundle\Entity\Dynamic;

/**
 * Dynamic list builder.
 */
interface DynamicListBuilderInterface
{
    /**
     * Build the list and return per line an array entry.
     *
     * @return mixed[]
     */
    public function build(Dynamic $dynamic, string $locale): array;
}
