<?php

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
