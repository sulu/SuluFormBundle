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
     * @return FieldDescriptor[]
     */
    public function getFieldDescriptors(string $webspace, string $locale, string $uuid): array;

    public function getEntityName(string $webspace, string $locale, string $uuid): string;
}
