<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Provider;

use Sulu\Component\Rest\ListBuilder\FieldDescriptor;

class ListProviderRegistry
{
    /**
     * @var ListProviderInterface[]
     */
    protected $providers = [];

    public function add(ListProviderInterface $provider, string $name): void
    {
        $this->providers[$name] = $provider;
    }

    /**
     * @return FieldDescriptor[]
     */
    public function getFieldDescriptors(string $template, string $webspace, string $locale, string $uuid): array
    {
        $provider = $this->getProvider($template);

        return $provider->getFieldDescriptors($webspace, $locale, $uuid);
    }

    public function getEntityName(string $template, string $webspace, string $locale, string $uuid): string
    {
        $provider = $this->getProvider($template);

        return $provider->getEntityName($webspace, $locale, $uuid);
    }

    /**
     * @return ListProviderInterface[]
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    protected function getProvider(string $template): ListProviderInterface
    {
        return $this->providers[$template];
    }
}
