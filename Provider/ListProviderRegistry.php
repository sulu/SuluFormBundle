<?php

namespace Sulu\Bundle\FormBundle\Provider;

use Sulu\Component\Rest\ListBuilder\FieldDescriptor;

class ListProviderRegistry
{
    /**
     * @var ListProviderInterface[]
     */
    protected $providers = [];

    /**
     * @param ListProviderInterface $provider
     * @param $name
     */
    public function add(ListProviderInterface $provider, $name)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * @param string $template
     * @param string $webspace
     * @param string $locale
     * @param string $uuid
     *
     * @return FieldDescriptor[]
     */
    public function getFieldDescriptors($template, $webspace, $locale, $uuid)
    {
        $provider = $this->getProvider($template);

        return $provider->getFieldDescriptors($webspace, $locale, $uuid);
    }

    /**
     * @param string $template
     * @param string $webspace
     * @param string $locale
     * @param string $uuid
     *
     * @return string
     */
    public function getEntityName($template, $webspace, $locale, $uuid)
    {
        $provider = $this->getProvider($template);

        return $provider->getEntityName($webspace, $locale, $uuid);
    }

    /**
     * @return ListProviderInterface[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param $template
     *
     * @return ListProviderInterface
     */
    protected function getProvider($template)
    {
        return $this->providers[$template];
    }
}
