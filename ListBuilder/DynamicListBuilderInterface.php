<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace L91\Sulu\Bundle\FormBundle\ListBuilder;

use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;

/**
 * Dynamic list builder.
 */
interface DynamicListBuilderInterface
{
    /**
     * Build the list and return per line an array entry.
     *
     * @param Dynamic $dynamic
     * @param $locale
     *
     * @return array
     */
    public function build(Dynamic $dynamic, $locale);
}
