<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Provider;

use Sulu\Component\Rest\ListBuilder\FieldDescriptor;

interface ListProviderInterface
{
    /**
     * @param string $webspace
     * @param string $locale
     * @param string $uuid
     *
     * @return FieldDescriptor[]
     */
    public function getFieldDescriptors($webspace, $locale, $uuid);

    /**
     * @param string $webspace
     * @param string $locale
     * @param string $uuid
     *
     * @return string
     */
    public function getEntityName($webspace, $locale, $uuid);
}
